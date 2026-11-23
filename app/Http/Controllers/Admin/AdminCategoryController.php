<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $categories = Category::query()
            ->with('parent')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.list_categories', compact('categories', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.create_category', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateCategory($request);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['name']);

        $category = Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория «'.$category->name.'» создана.');
    }

    public function edit(Category $category)
    {
        $categories = Category::where('category_id', '!=', $category->category_id)
            ->orderBy('name')
            ->get();

        return view('admin.edit_category', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateCategory($request, $category);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? null, $data['name'], $category);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория «'.$category->name.'» обновлена.');
    }

    public function destroy(Category $category)
    {
        $name = $category->name;

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория «'.$name.'» удалена.');
    }

    private function validateCategory(Request $request, ?Category $category = null): array
    {
        $slugRule = Rule::unique('categories', 'slug');
        $parentRules = ['nullable', 'integer', 'exists:categories,category_id'];

        if ($category) {
            $slugRule->ignore($category->category_id, 'category_id');
            $parentRules[] = Rule::notIn([$category->category_id]);
        }

        $data = $request->validate([
            'parent_id' => $parentRules,
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $slugRule],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'parent_id.exists' => 'Выбранная родительская категория не найдена.',
            'parent_id.not_in' => 'Категория не может быть родительской для самой себя.',
            'name.required' => 'Укажите название категории.',
            'slug.unique' => 'Такой slug уже используется.',
            'sort_order.integer' => 'Порядок сортировки должен быть целым числом.',
            'image_file.image' => 'Файл должен быть изображением.',
            'image_file.mimes' => 'Поддерживаются форматы jpg, jpeg, png и webp.',
            'image_file.max' => 'Размер изображения не должен превышать 4 МБ.',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['parent_id'] = ! empty($data['parent_id']) ? $data['parent_id'] : null;

        if ($request->boolean('remove_image')) {
            $data['image_url'] = null;
        } elseif ($request->hasFile('image_file')) {
            $data['image_url'] = $this->storeImage($request->file('image_file'));
        } else {
            $imageUrl = trim((string) ($data['image_url'] ?? ''));
            $data['image_url'] = $imageUrl !== '' ? $imageUrl : null;
        }

        unset($data['image_file']);

        return $data;
    }

    private function uniqueSlug(?string $slug, string $name, ?Category $category = null): string
    {
        $base = Str::slug($slug ?: $name);

        if ($base === '') {
            $base = 'category';
        }

        $candidate = $base;
        $counter = 2;

        while (Category::query()
            ->where('slug', $candidate)
            ->when($category, fn ($query) => $query->where('category_id', '!=', $category->category_id))
            ->exists()) {
            $candidate = $base.'-'.$counter;
            $counter++;
        }

        return $candidate;
    }

    private function storeImage(UploadedFile $file): string
    {
        $directory = public_path('uploads/categories');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = (string) Str::uuid().'.'.strtolower($file->getClientOriginalExtension());

        $file->move($directory, $filename);

        return 'uploads/categories/'.$filename;
    }
}
