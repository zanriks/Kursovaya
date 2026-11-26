<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Favorite;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Request $request, string $slug)
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

        $userReview = auth()->check()
            ? Review::query()
                ->where('product_id', $product->product_id)
                ->where('user_id', auth()->id())
                ->first()
            : null;

        $favoriteIds = Favorite::idsForUser($request->user()?->user_id);

        return view('product_card', compact('product', 'userReview', 'favoriteIds'));
    }
}
