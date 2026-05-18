@extends('layouts.app')
@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">
    <h1 class="text-3xl font-extrabold text-slate-900 mb-8">🛒 Your Cart</h1>

    @if(empty($cart))
        <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center shadow-sm">
            <div class="text-6xl mb-4">🛒</div>
            <h3 class="text-xl font-semibold text-slate-700 mb-2">Your cart is empty</h3>
            <p class="text-slate-400 mb-6">Add some great products to get started.</p>
            <a href="{{ route('products.index') }}"
               class="inline-block bg-indigo-600 text-white font-semibold px-8 py-3 rounded-xl hover:bg-indigo-700 transition-colors">
                Browse Products
            </a>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
            @php $total = 0 @endphp
            @foreach($cart as $id => $item)
                @php $total += $item['price'] * $item['quantity'] @endphp
                <div class="flex items-center gap-4 p-5 border-b border-slate-100 last:border-0">
                    <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        @if($item['image'])
                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <span class="text-2xl">📦</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-800 truncate">{{ $item['name'] }}</p>
                        <p class="text-sm text-slate-500">Qty: {{ $item['quantity'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-indigo-700">₹{{ number_format($item['price'] * $item['quantity'], 0) }}</p>
                        <p class="text-xs text-slate-400">₹{{ number_format($item['price'], 0) }} each</p>
                    </div>
                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-slate-300 hover:text-rose-500 transition-colors p-1" title="Remove">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                </div>
            @endforeach

            <div class="flex items-center justify-between p-5 bg-slate-50">
                <span class="font-semibold text-slate-700">Total</span>
                <span class="text-2xl font-extrabold text-indigo-700">₹{{ number_format($total, 0) }}</span>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('products.index') }}"
               class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-colors">
                Continue Shopping
            </a>
            <a href="{{ route('checkout') }}"
               class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition-colors shadow-sm">
                Proceed to Checkout →
            </a>
        </div>
    @endif
</div>
@endsection
