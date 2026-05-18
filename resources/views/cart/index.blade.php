@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Your Cart</h1>
    
    @if(empty($cart))
        <p>Cart is empty</p>
    @else
        <div class="space-y-4">
            @foreach($cart as $id => $item)
            <div class="flex justify-between items-center border p-4 rounded">
                <div>{{ $item['name'] }} × {{ $item['quantity'] }}</div>
                <div>₹{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                <form action="{{ route('cart.remove', $id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600">Remove</button>
                </form>
            </div>
            @endforeach
        </div>
        <a href="{{ route('checkout') }}" class="bg-green-600 text-white px-6 py-3 mt-6 inline-block rounded">Proceed to Checkout</a>
    @endif
</div>
@endsection