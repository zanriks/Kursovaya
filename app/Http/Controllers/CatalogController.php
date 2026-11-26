<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('catalog', compact('categories'));
    }

    public function show(Request $request, string $slug)
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $data = $request->validate([
            'price_min' => ['nullable', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'numeric', 'min:0'],
            'price_range' => ['nullable', 'regex:/^\d+-\d+$/'],
            'manufacturer' => ['nullable', 'array'],
            'manufacturer.*' => ['string', 'max:100'],
            'rating_min' => ['nullable', 'numeric', 'between:0,5'],
            'is_hit' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'in:default,price_asc,price_desc,rating_desc,new,name_asc'],
        ]);

        $productsQuery = $category->products()
            ->with('primaryImage')
            ->withCount('reviews')
            ->where('is_active', true);

        // Цена от
        if ($request->filled('price_min')) {
            $productsQuery->where('price', '>=', $data['price_min']);
        }

        // Цена до
        if ($request->filled('price_max')) {
            $productsQuery->where('price', '<=', $data['price_max']);
        }

        // Быстрый диапазон цены
        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $data['price_range'], 2);

            $productsQuery->whereBetween('price', [
                (float) $min,
                (float) $max,
            ]);
        }

        // Производители
        if (!empty($data['manufacturer'])) {
            $productsQuery->whereIn('manufacturer', $data['manufacturer']);
        }

        // Рейтинг 4 и выше
        if ($request->filled('rating_min')) {
            $productsQuery->where('rating_cache', '>=', $data['rating_min']);
        }

        // Только хиты
        if ($request->boolean('is_hit')) {
            $productsQuery->where('is_hit', true);
        }

        $sort = $data['sort'] ?? 'default';

        switch ($sort) {
            case 'price_asc':
                $productsQuery->orderBy('price');
                break;

            case 'price_desc':
                $productsQuery->orderByDesc('price');
                break;

            case 'rating_desc':
                $productsQuery->orderByDesc('rating_cache');
                break;

            case 'new':
                $productsQuery->orderByDesc('created_at');
                break;

            case 'name_asc':
                $productsQuery->orderBy('name');
                break;

            case 'default':
            default:
                $productsQuery->orderByDesc('is_hit')
                    ->orderByDesc('rating_cache');
                break;
        }

        // Стабильная сортировка при одинаковых значениях
        $productsQuery->orderBy('product_id');

        $products = $productsQuery->get();

        $manufacturers = Product::query()
            ->where('category_id', $category->category_id)
            ->where('is_active', true)
            ->whereNotNull('manufacturer')
            ->distinct()
            ->orderBy('manufacturer')
            ->pluck('manufacturer');

        $cartItems = CartItem::forUserKeyedByProduct(
            $request->user()?->user_id
        );

        $favoriteIds = Favorite::idsForUser($request->user()?->user_id);

        return view('catalog_instrument', compact(
            'category',
            'products',
            'manufacturers',
            'cartItems',
            'favoriteIds'
        ));
    }

    public function search(Request $request)
    {
        $query = trim((string) $request->input('q'));

        if ($query === '') {
            return redirect()->route('catalog');
        }

        $like = '%' . addcslashes($query, '%_\\') . '%';

        $products = Product::query()
            ->with(['primaryImage', 'category'])
            ->withCount('reviews')
            ->where('is_active', true)
            ->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)
                    ->orWhere('sku', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('category', function ($category) use ($like) {
                        $category->where('name', 'like', $like);
                    });
            })
            ->orderByDesc('is_hit')
            ->orderByDesc('rating_cache')
            ->paginate(20)
            ->withQueryString();

        $cartItems = CartItem::forUserKeyedByProduct(
            $request->user()?->user_id
        );

        $favoriteIds = Favorite::idsForUser($request->user()?->user_id);

        return view('search', compact('products', 'query', 'cartItems', 'favoriteIds'));
    }
}
