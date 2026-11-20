<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
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

    public function update(Request $request, CartItem $item)
    {
        $cart = $this->getCart($request);

        abort_unless((int) $item->cart_id === (int) $cart->cart_id, 404);

        $data = $request->validate([
            'action' => ['required', 'in:increment,decrement,remove'],
        ], [
            'action.required' => 'Не выбрано действие.',
            'action.in' => 'Некорректное действие.',
        ]);

        switch ($data['action']) {
            case 'increment':
                if ($item->quantity >= 99) {
                    return back()->with(
                        'cart_success',
                        'Максимум 99 единиц одного товара.'
                    );
                }

                $item->increment('quantity');
                $message = 'Количество увеличено.';
                break;

            case 'decrement':
                if ($item->quantity <= 1) {
                    $item->delete();
                    $message = 'Товар удалён из корзины.';
                } else {
                    $item->decrement('quantity');
                    $message = 'Количество уменьшено.';
                }
                break;

            case 'remove':
                $item->delete();
                $message = 'Товар удалён из корзины.';
                break;
        }

        return back()->with('cart_success', $message);
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
