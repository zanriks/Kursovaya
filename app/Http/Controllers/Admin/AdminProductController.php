<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $products = Product::query()
            ->with([
                'category',
                'images' => fn ($query) => $query->orderBy('sort_order'),
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('product_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.list_products', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.create_product', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        $data['created_by'] = Auth::id();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['name']);

        $product = DB::transaction(function () use ($request, $data) {
            $product = Product::create($data);
            $this->syncImages($product, $request);
            $this->syncSpecifications($product, $request);

            return $product;
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар «'.$product->name.'» создан.');
    }

    public function edit(Product $product)
    {
        $product->load([
            'images' => fn ($query) => $query->orderBy('sort_order'),
            'specifications' => fn ($query) => $query->orderBy('sort_order'),
        ]);

        $categories = Category::orderBy('name')->get();

        return view('admin.edit_product', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request, $product);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['name'], $product);

        DB::transaction(function () use ($request, $product, $data) {
            $product->update($data);
            $this->syncImages($product, $request);
            $this->syncSpecifications($product, $request);
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар «'.$product->name.'» обновлён.');
    }

    public function destroy(Product $product)
    {
        $name = $product->name;

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар «'.$name.'» удалён.');
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        $skuRule = Rule::unique('products', 'sku');
        $slugRule = Rule::unique('products', 'slug');

        if ($product) {
            $skuRule->ignore($product->product_id, 'product_id');
            $slugRule->ignore($product->product_id, 'product_id');
        }

        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,category_id'],
            'sku' => ['required', 'string', 'max:100', $skuRule],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $slugRule],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'rating_cache' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'is_active' => ['nullable', 'boolean'],
            'is_hit' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*.image_url' => ['nullable', 'string', 'max:255'],
            'images.*.alt_text' => ['nullable', 'string', 'max:255'],
            'images.*.is_primary' => ['nullable', 'boolean'],
            'images.*.image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.name' => ['nullable', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string', 'max:255'],
        ], [
            'category_id.required' => 'Выберите категорию.',
            'category_id.exists' => 'Выбранная категория не найдена.',
            'sku.required' => 'Укажите артикул.',
            'sku.unique' => 'Товар с таким артикулом уже существует.',
            'name.required' => 'Укажите название товара.',
            'slug.unique' => 'Такой slug уже используется.',
            'price.required' => 'Укажите цену.',
            'price.numeric' => 'Цена должна быть числом.',
            'old_price.numeric' => 'Старая цена должна быть числом.',
            'rating_cache.between' => 'Рейтинг должен быть от 0 до 5.',
            'images.*.image_file.image' => 'Файл должен быть изображением.',
            'images.*.image_file.mimes' => 'Поддерживаются форматы jpg, jpeg, png и webp.',
            'images.*.image_file.max' => 'Размер изображения не должен превышать 4 МБ.',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_hit'] = $request->boolean('is_hit');
        $data['rating_cache'] = $data['rating_cache'] ?? 0;
        $data['old_price'] = isset($data['old_price']) && $data['old_price'] !== ''
            ? $data['old_price']
            : null;

        return $data;
    }

    private function uniqueSlug(?string $slug, string $name, ?Product $product = null): string
    {
        $base = Str::slug($slug ?: $name);

        if ($base === '') {
            $base = 'product';
        }

        $candidate = $base;
        $counter = 2;

        while (Product::query()
            ->where('slug', $candidate)
            ->when($product, fn ($query) => $query->where('product_id', '!=', $product->product_id))
            ->exists()) {
            $candidate = $base.'-'.$counter;
            $counter++;
        }

        return $candidate;
    }

    private function syncImages(Product $product, Request $request): void
    {
        $rows = $request->input('images', []);
        $files = $request->file('images', []);

        if (! is_array($rows)) {
            $rows = [];
        }

        if (! is_array($files)) {
            $files = [];
        }

        $product->images()->delete();

        $primaryAssigned = false;
        $sortOrder = 0;

        foreach ($rows as $index => $row) {
            $imageUrl = trim((string) ($row['image_url'] ?? ''));
            $file = $files[$index]['image_file'] ?? null;

            if ($file instanceof UploadedFile) {
                $imageUrl = $this->storeImage($file);
            }

            if ($imageUrl === '') {
                continue;
            }

            $isPrimary = ! $primaryAssigned && (bool) ($row['is_primary'] ?? false);

            if ($isPrimary) {
                $primaryAssigned = true;
            }

            $product->images()->create([
                'image_url' => $imageUrl,
                'alt_text' => $row['alt_text'] ?? null,
                'sort_order' => $sortOrder++,
                'is_primary' => $isPrimary,
            ]);
        }

        if (! $primaryAssigned) {
            $product->images()
                ->orderBy('sort_order')
                ->first()
                ?->update(['is_primary' => true]);
        }
    }

    private function syncSpecifications(Product $product, Request $request): void
    {
        $rows = $request->input('specifications', []);

        if (! is_array($rows)) {
            $rows = [];
        }

        $product->specifications()->delete();

        $sortOrder = 0;

        foreach ($rows as $row) {
            $name = trim((string) ($row['name'] ?? ''));
            $value = trim((string) ($row['value'] ?? ''));

            if ($name === '' || $value === '') {
                continue;
            }

            $product->specifications()->create([
                'name' => $name,
                'value' => $value,
                'sort_order' => $sortOrder++,
            ]);
        }
    }

    private function storeImage(UploadedFile $file): string
    {
        $directory = public_path('uploads/products');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = (string) Str::uuid().'.'.strtolower($file->getClientOriginalExtension());

        $file->move($directory, $filename);

        return 'uploads/products/'.$filename;
    }
}
