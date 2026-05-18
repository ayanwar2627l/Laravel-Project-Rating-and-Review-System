<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty');
        }
        return view('order.checkout', compact('cart'));
    }

    public function place(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'completed'
        ]);

        // Create Order Items
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // Clear Cart
        session()->forget('cart');

        return redirect()->route('my.orders')
                         ->with('success', 'Order placed successfully! You can now write verified reviews.');
    }
    
    public function myOrders()
    {
    $orders = auth()->user()->orders()->with('items.product')->latest()->get();
    return view('order.my-orders', compact('orders'));   // This is correct
    }
}