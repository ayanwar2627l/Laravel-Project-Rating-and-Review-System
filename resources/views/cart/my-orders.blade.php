@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">My Orders</h1>
    @foreach($orders as $order)
        <div class="border p-4 mb-4 rounded">
            <p>Order #{{ $order->id }} | Total: ₹{{ number_format($order->total_amount, 2) }}</p>
        </div>
    @endforeach
</div>
@endsection