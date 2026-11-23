<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with('items')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless(
            auth()->check() && (int) $order->user_id === (int) auth()->id(),
            403
        );

        $order->load('items');

        return view('orders.show', compact('order'));
    }
}
