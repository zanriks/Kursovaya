<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $cart = $this->getCart($user->user_id);

        $items = $cart->items()
            ->with('product.primaryImage')
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Корзина пуста. Добавьте товары перед оформлением заказа.');
        }

        $total = $items->sum(function ($item) {
            return (float) $item->price_at_add * $item->quantity;
        });

        $defaultName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        $defaultName = $defaultName !== '' ? $defaultName : $user->login;

        return view('checkout.index', compact(
            'items',
            'total',
            'user',
            'defaultName'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'delivery_address' => ['required', 'string', 'min:5', 'max:1000'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ], [
            'customer_name.required' => 'Укажите имя получателя.',
            'customer_name.max' => 'Имя слишком длинное.',

            'email.required' => 'Укажите email.',
            'email.email' => 'Введите корректный email.',

            'delivery_address.required' => 'Укажите адрес доставки.',
            'delivery_address.min' => 'Адрес доставки слишком короткий.',

            'comment.max' => 'Комментарий слишком длинный.',
        ]);

        $user = $request->user();

        $cart = $this->getCart($user->user_id);

        $items = $cart->items()
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Корзина пуста. Заказ не оформлен.');
        }

        // Пересчитываем сумму на сервере, не доверяем форме
        $total = $items->sum(function ($item) {
            return (float) $item->price_at_add * $item->quantity;
        });

        $order = DB::transaction(function () use ($data, $items, $total, $cart, $user) {
            $order = Order::create([
                'user_id' => $user->user_id,
                'status' => 'new',
                'customer_name' => $data['customer_name'],
                'email' => $data['email'],
                'delivery_address' => $data['delivery_address'],
                'comment' => $data['comment'] ?? null,
                'total_amount' => $total,
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name_snapshot' => $item->product?->name ?? 'Товар удалён',
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price_at_add,
                ]);
            }

            // Старую корзину закрываем.
            // При следующем добавлении товара getCart() создаст новую активную корзину.
            $cart->update([
                'status' => 'completed',
            ]);

            return $order;
        });

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        abort_unless(
            auth()->check() && (int) $order->user_id === (int) auth()->id(),
            403
        );

        $order->load('items');

        return view('checkout.success', compact('order'));
    }

    private function getCart(int $userId): Cart
    {
        return Cart::firstOrCreate(
            [
                'user_id' => $userId,
                'status' => 'active',
            ],
            [
                'session_key' => null,
            ]
        );
    }
}