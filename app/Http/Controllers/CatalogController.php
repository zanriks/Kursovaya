<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
}