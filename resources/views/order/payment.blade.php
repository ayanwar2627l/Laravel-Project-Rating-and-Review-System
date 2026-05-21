@extends('layouts.app')
@section('title', 'Payment')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10" x-data="paymentForm()">

    <!-- Header -->
    <div class="mb-8">
        <nav class="text-sm text-slate-400 mb-2 flex items-center gap-2">
            <a href="{{ route('cart.index') }}" class="hover:text-indigo-600 transition-colors">Cart</a>
            <span>/</span>
            <a href="{{ route('checkout') }}" class="hover:text-indigo-600 transition-colors">Checkout</a>
            <span>/</span>
            <span class="text-slate-700 font-medium">Payment</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-slate-900">Secure Payment</h1>
    </div>

    <!-- Steps -->
    <div class="flex items-center gap-0 mb-10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm font-bold">✓</div>
            <span class="text-sm font-semibold text-emerald-600">Shipping</span>
        </div>
        <div class="flex-1 h-0.5 bg-indigo-300 mx-3"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm font-bold">2</div>
            <span class="text-sm font-semibold text-indigo-700">Payment</span>
        </div>
        <div class="flex-1 h-0.5 bg-slate-200 mx-3"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-sm font-bold">3</div>
            <span class="text-sm text-slate-400">Confirmed</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Payment Form -->
        <div class="lg:col-span-2 space-y-5">

            <!-- Demo Notice -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">
                <span class="text-amber-500 text-xl flex-shrink-0 mt-0.5">⚠️</span>
                <div class="text-sm text-amber-800">
                    <strong>Demo Mode:</strong> This is a simulation. No real payment is processed.
                    Enter any valid-looking card details (e.g. 4111 1111 1111 1111) to complete the order.
                </div>
            </div>

            <!-- Shipping address summary -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-bold text-slate-800">Delivering to</h2>
                    <a href="{{ route('checkout') }}" class="text-xs text-indigo-600 hover:underline">Edit</a>
                </div>
                <div class="text-sm text-slate-600 leading-relaxed">
                    <p class="font-semibold text-slate-800">{{ $address['full_name'] }}</p>
                    <p>{{ $address['address'] }}, {{ $address['city'] }}, {{ $address['state'] }} – {{ $address['pincode'] }}</p>
                    <p class="text-slate-400 mt-0.5">📞 {{ $address['phone'] }}</p>
                </div>
            </div>

            <!-- Card Form -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-slate-800">Card Details</h2>
                    <div class="flex items-center gap-2 text-slate-400 text-xs">
                        <span>💳</span><span>🔒 SSL Secured</span>
                    </div>
                </div>

                <!-- Visual card preview -->
                <div class="relative w-full max-w-sm mx-auto mb-8 h-44 rounded-2xl p-6 text-white shadow-xl overflow-hidden"
                     style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                    <div class="absolute inset-0 opacity-10"
                         style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;"></div>
                    <div class="relative">
                        <div class="flex justify-between items-start mb-6">
                            <span class="text-xs font-medium tracking-widest opacity-70">DEMO CARD</span>
                            <div class="flex gap-1">
                                <div class="w-7 h-7 rounded-full bg-amber-400 opacity-90"></div>
                                <div class="w-7 h-7 rounded-full bg-amber-200 opacity-60 -ml-3"></div>
                            </div>
                        </div>
                        <div class="font-mono text-lg tracking-widest mb-4 opacity-90" x-text="displayNumber"></div>
                        <div class="flex justify-between items-end text-xs">
                            <div>
                                <div class="opacity-60 mb-0.5">CARD HOLDER</div>
                                <div class="font-semibold uppercase tracking-wide" x-text="cardName || 'YOUR NAME'"></div>
                            </div>
                            <div class="text-right">
                                <div class="opacity-60 mb-0.5">EXPIRES</div>
                                <div class="font-semibold" x-text="cardExpiry || 'MM/YY'"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('payment.process') }}" method="POST" @submit="submitting = true">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Card Number</label>
                            <input type="text" name="card_number" x-model="rawNumber"
                                   @input="formatNumber"
                                   :value="displayNumber"
                                   maxlength="19"
                                   class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm font-mono tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="1234 5678 9012 3456">
                            @error('card_number')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Name on Card</label>
                            <input type="text" name="card_name" x-model="cardName"
                                   class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="AS ON YOUR CARD">
                            @error('card_name')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Expiry Date</label>
                                <input type="text" name="expiry" x-model="cardExpiry"
                                       @input="formatExpiry"
                                       maxlength="5"
                                       class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm font-mono tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="MM/YY">
                                @error('expiry')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">CVV</label>
                                <input type="password" name="cvv" maxlength="4"
                                       class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm font-mono tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="•••">
                                @error('cvv')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            :disabled="submitting"
                            class="mt-8 w-full bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl transition-colors shadow-sm text-base flex items-center justify-center gap-2">
                        <span x-show="!submitting">🔒 Pay ₹{{ number_format($total, 0) }}</span>
                        <span x-show="submitting" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </form>
            </div>
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

                <div class="mt-5 bg-emerald-50 rounded-xl p-3 text-xs text-emerald-700 space-y-1">
                    <p>✓ After payment, reviews for purchased products are automatically <strong>Verified Buyer</strong>.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function paymentForm() {
    return {
        rawNumber: '',
        displayNumber: '•••• •••• •••• ••••',
        cardName: '',
        cardExpiry: '',
        submitting: false,
        formatNumber() {
            let v = this.rawNumber.replace(/\D/g, '').substring(0, 16);
            this.displayNumber = v.replace(/(.{4})/g, '$1 ').trim() || '•••• •••• •••• ••••';
            this.rawNumber = this.displayNumber;
        },
        formatExpiry() {
            let v = this.cardExpiry.replace(/\D/g, '').substring(0, 4);
            if (v.length >= 2) {
                this.cardExpiry = v.substring(0, 2) + '/' + v.substring(2);
            } else {
                this.cardExpiry = v;
            }
        }
    }
}
</script>
@endsection
