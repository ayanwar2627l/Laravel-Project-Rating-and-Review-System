@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h1>{{ $product->name }}</h1>
    <!-- Will be filled later with reviews -->
     <form action="{{ route('cart.add', $product) }}" method="POST">
        @csrf
        <button type="submit" class="bg-green-600 text-white px-4 py-2 mt-2 rounded">Add to Cart</button>
    </form>
</div>
@endsection