@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-lg mx-auto px-4 sm:px-6 py-10">
    <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Checkout</h1>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
        <h2 class="font-semibold text-slate-700 mb-4">Order Summary</h2>
        @php $total = 0 @endphp
        @foreach($cart as $id => $item)
            @php $total += $item['price'] * $item['quantity'] @endphp
            <div class="flex justify-between text-sm py-2 border-b border-slate-100 last:border-0">
                <span class="text-slate-700">{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                <span class="font-semibold text-slate-800">₹{{ number_format($item['price'] * $item['quantity'], 0) }}</span>
            </div>
        @endforeach
        <div class="flex justify-between mt-4 pt-2">
            <span class="font-bold text-slate-800">Total</span>
            <span class="text-2xl font-extrabold text-indigo-700">₹{{ number_format($total, 0) }}</span>
        </div>
    </div>

    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-sm text-amber-800">
        ℹ️ This is a demo system. No real payment is processed. Placing an order unlocks "Verified Buyer" status for reviews.
    </div>

    <form action="{{ route('order.place') }}" method="POST">
        @csrf
        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-colors shadow-sm text-lg">
            Place Order — ₹{{ number_format($total, 0) }}
        </button>
    </form>

    <a href="{{ route('cart.index') }}" class="mt-4 block text-center text-slate-400 hover:text-slate-600 text-sm">
        ← Back to cart
    </a>
</div>
@endsection
