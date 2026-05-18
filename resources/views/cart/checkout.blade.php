@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>
    <p class="mb-4">Total: <strong>₹{{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 2) }}</strong></p>
    
    <form action="{{ route('order.place') }}" method="POST">
        @csrf
        <button type="submit" class="bg-blue-600 text-white px-8 py-4 text-xl rounded w-full">
            Place Fake Order (for Testing)
        </button>
    </form>
</div>
@endsection