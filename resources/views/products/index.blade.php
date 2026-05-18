@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Products</h1>
    
    <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-6 inline-block">
        Add New Product
    </a>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="border rounded-lg overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover">
            @endif
            <div class="p-4">
                <h3 class="font-semibold">{{ $product->name }}</h3>
                <p class="text-gray-600 text-sm">{{ $product->category->name ?? 'N/A' }}</p>
                <p class="font-bold text-lg">₹{{ number_format($product->price, 2) }}</p>
                <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline">View Details</a>
            </div>
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 mt-2 rounded">Add to Cart</button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection