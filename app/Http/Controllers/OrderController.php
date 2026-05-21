<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('order.checkout', compact('cart', 'total'));
    }

    public function place(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string|max:500',
            'city'      => 'required|string|max:100',
            'state'     => 'required|string|max:100',
            'pincode'   => 'required|string|max:10',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Store shipping details in session for payment page
        session(['checkout_address' => $request->only(
            'full_name', 'phone', 'address', 'city', 'state', 'pincode'
        )]);

        return redirect()->route('payment');
    }

    public function payment()
    {
        $cart    = session()->get('cart', []);
        $address = session()->get('checkout_address');

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        if (empty($address)) {
            return redirect()->route('checkout')->with('error', 'Please fill in your shipping details first.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('order.payment', compact('cart', 'address', 'total'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'card_name'   => 'required|string|max:255',
            'card_number' => 'required|string|size:19',
            'expiry'      => 'required|string',
            'cvv'         => 'required|string|min:3|max:4',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id'      => auth()->id(),
            'total_amount' => $total,
            'status'       => 'completed',
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            // Decrement stock
            Product::where('id', $productId)->decrement('stock', $item['quantity']);
        }

        session()->forget(['cart', 'checkout_address']);

        return redirect()->route('home')
            ->with('success', '🎉 Order #' . $order->id . ' placed successfully! You can now write a Verified Buyer review for your purchases.');
    }

    public function myOrders()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->get();
        return view('order.my-orders', compact('orders'));
    }
}
