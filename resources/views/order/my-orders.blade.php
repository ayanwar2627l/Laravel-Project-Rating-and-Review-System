@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
    <h1 class="text-3xl font-extrabold text-slate-900 mb-8">My Orders</h1>

    @if($orders->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center shadow-sm">
            <div class="text-6xl mb-4">📋</div>
            <h3 class="text-xl font-semibold text-slate-700 mb-2">No orders yet</h3>
            <p class="text-slate-400 mb-6">Start shopping to place your first order.</p>
            <a href="{{ route('products.index') }}"
               class="inline-block bg-indigo-600 text-white font-semibold px-8 py-3 rounded-xl hover:bg-indigo-700 transition-colors">
                Browse Products
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-slate-500">Order #{{ $order->id }}</p>
                            <p class="text-xs text-slate-400">{{ $order->created_at->format('M j, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold px-3 py-1 rounded-full">
                                {{ ucfirst($order->status) }}
                            </span>
                            <p class="font-bold text-indigo-700 text-lg mt-1">₹{{ number_format($order->total_amount, 0) }}</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                        @if($item->product?->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <span>📦</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $item->product?->name ?? 'Product removed' }}</p>
                                        <p class="text-slate-400">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-semibold text-slate-700">₹{{ number_format($item->price * $item->quantity, 0) }}</span>
                                    @if($item->product)
                                        <a href="{{ route('reviews.create', $item->product) }}"
                                           class="text-xs bg-amber-50 border border-amber-200 text-amber-700 px-3 py-1.5 rounded-lg hover:bg-amber-100 transition-colors font-medium">
                                            ★ Review
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
