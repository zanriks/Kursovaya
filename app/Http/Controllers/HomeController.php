<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $hits = Product::query()
            ->with(['primaryImage'])
            ->withCount('reviews')
            ->where('is_active', true)
            ->where('is_hit', true)
            ->orderByDesc('rating_cache')
            ->take(5)
            ->get();

        return view('welcome', compact('categories', 'hits'));
    }
}