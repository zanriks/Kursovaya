<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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

    public function show(string $slug)
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $category->products()
            ->with('primaryImage')
            ->withCount('reviews')
            ->where('is_active', true)
            ->orderByDesc('is_hit')
            ->orderByDesc('rating_cache')
            ->get();

        return view('catalog_instrument', compact('category', 'products'));
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

        return view('search', compact('products', 'query'));
    }
}
