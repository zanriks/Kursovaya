<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $productIds = auth()->user()
            ->favorites()
            ->pluck('product_id');

        $products = Product::query()
            ->whereIn('product_id', $productIds)
            ->with('primaryImage')
            ->withCount('reviews')
            ->get();

        $cartItems = CartItem::forUserKeyedByProduct($userId);

        $favoriteIds = Favorite::idsForUser($userId);

        return view('izbrannoe', compact(
            'products',
            'cartItems',
            'favoriteIds'
        ));
    }

    public function toggle(Product $product)
    {
        $favorite = Favorite::query()
            ->where('user_id', auth()->id())
            ->where('product_id', $product->product_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Товар удалён из избранного.';
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'product_id' => $product->product_id,
            ]);
            $message = 'Товар добавлен в избранное.';
        }

        return back()->with('favorite_success', $message);
    }
}