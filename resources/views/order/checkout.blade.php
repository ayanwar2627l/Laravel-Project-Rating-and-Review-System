@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

    <!-- Header -->
    <div class="mb-8">
        <nav class="text-sm text-slate-400 mb-2 flex items-center gap-2">
            <a href="{{ route('cart.index') }}" class="hover:text-indigo-600 transition-colors">Cart</a>
            <span>/</span>
            <span class="text-slate-700 font-medium">Checkout</span>
            <span>/</span>
            <span class="text-slate-400">Payment</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-slate-900">Shipping Details</h1>
    </div>

    <!-- Steps -->
    <div class="flex items-center gap-0 mb-10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm font-bold">1</div>
            <span class="text-sm font-semibold text-indigo-700">Shipping</span>
        </div>
        <div class="flex-1 h-0.5 bg-slate-200 mx-3"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-sm font-bold">2</div>
            <span class="text-sm text-slate-400">Payment</span>
        </div>
        <div class="flex-1 h-0.5 bg-slate-200 mx-3"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-sm font-bold">3</div>
            <span class="text-sm text-slate-400">Confirmed</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Shipping Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('order.place') }}" method="POST" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                @csrf

                <h2 class="text-lg font-bold text-slate-800 mb-6">Delivery Address</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('full_name') border-rose-400 @enderror"
                               placeholder="Enter your full name">
                        @error('full_name')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('phone') border-rose-400 @enderror"
                               placeholder="10-digit mobile number">
                        @error('phone')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Address <span class="text-rose-500">*</span></label>
                        <textarea name="address" rows="2"
                                  class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('address') border-rose-400 @enderror"
                                  placeholder="House / Flat no., Street, Area">{{ old('address') }}</textarea>
                        @error('address')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">City <span class="text-rose-500">*</span></label>
                        <input type="text" name="city" value="{{ old('city') }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('city') border-rose-400 @enderror"
                               placeholder="City">
                        @error('city')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">State <span class="text-rose-500">*</span></label>
                        <input type="text" name="state" value="{{ old('state') }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('state') border-rose-400 @enderror"
                               placeholder="State">
                        @error('state')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Pincode <span class="text-rose-500">*</span></label>
                        <input type="text" name="pincode" value="{{ old('pincode') }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('pincode') border-rose-400 @enderror"
                               placeholder="6-digit pincode" maxlength="6">
                        @error('pincode')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-8 flex items-center gap-4">
                    <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-colors shadow-sm text-base">
                        Continue to Payment →
                    </button>
                    <a href="{{ route('cart.index') }}"
                       class="text-slate-500 hover:text-slate-700 text-sm font-medium transition-colors">
                        ← Back to cart
                    </a>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-24">
                <h2 class="font-bold text-slate-800 mb-5">Order Summary</h2>

                <div class="space-y-3 mb-5">
                    @foreach($cart as $id => $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600 flex-1 pr-3 leading-snug">
                                {{ $item['name'] }}
                                <span class="text-slate-400">× {{ $item['quantity'] }}</span>
                            </span>
                            <span class="font-semibold text-slate-800 whitespace-nowrap">
                                ₹{{ number_format($item['price'] * $item['quantity'], 0) }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <div class="flex justify-between text-sm text-slate-500 mb-1">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($total, 0) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-emerald-600 mb-3">
                        <span>Shipping</span>
                        <span class="font-medium">Free</span>
                    </div>
                    <div class="flex justify-between font-bold text-slate-900 text-lg">
                        <span>Total</span>
                        <span class="text-indigo-700">₹{{ number_format($total, 0) }}</span>
                    </div>
                </div>

                <div class="mt-5 bg-indigo-50 rounded-xl p-3 text-xs text-indigo-700">
                    🛡️ After purchase, your reviews for these products will be marked as <strong>Verified Buyer</strong>.
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
