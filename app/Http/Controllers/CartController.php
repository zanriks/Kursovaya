<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user() ? $this->getCart($request) : null;

        $items = $cart
            ? $cart->items()->with('product.primaryImage')->get()
            : collect();

        $total = $items->sum(function ($item) {
            return (float) $item->price_at_add * $item->quantity;
        });

        return view('cart', compact('cart', 'items', 'total'));
    }
    public function add(Request $request, string $slug)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ], [
            'quantity.integer' => 'Количество должно быть числом.',
            'quantity.min' => 'Количество должно быть не меньше 1.',
            'quantity.max' => 'За один раз можно добавить не больше 99 единиц.',
        ]);

        $quantity = (int) ($data['quantity'] ?? 1);

        $cart = $this->getCart($request);

        $item = $cart->items()
            ->where('product_id', $product->product_id)
            ->first();

        if ($item) {
            $item->quantity = min(99, $item->quantity + $quantity);
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->product_id,
                'quantity' => $quantity,
                'price_at_add' => $product->price,
            ]);
        }

        return back()->with(
            'cart_success',
            'Товар добавлен в корзину.'
        );
    }

    private function getCart(Request $request): Cart
    {
        return Cart::firstOrCreate(
            [
                'user_id' => $request->user()->user_id,
                'status' => 'active',
            ],
            [
                'session_key' => null,
            ]
        );
    }
}
