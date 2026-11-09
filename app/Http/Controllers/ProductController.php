<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::query()
            ->with([
                'category',
                'images' => fn ($query) => $query->orderBy('sort_order'),
                'specifications' => fn ($query) => $query->orderBy('sort_order'),
                'reviews' => fn ($query) => $query
                    ->where('status', 'approved')
                    ->with('user')
                    ->latest(),
            ])
            ->withCount([
                'reviews' => fn ($query) => $query->where('status', 'approved'),
            ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('product_card', compact('product'));
    }
}