@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>
        <p class="text-2xl font-bold text-green-600">₹{{ number_format($product->price, 2) }}</p>

        <!-- Average Rating -->
        <div class="flex items-center gap-2 mt-4">
            <div class="text-3xl text-yellow-400">★</div>
            <span class="text-2xl">{{ $product->average_rating }}/5</span>
            <span class="text-gray-500">({{ $product->review_count }} reviews)</span>
        </div>

        <div class="mt-8 border-t pt-8">
            <h2 class="text-2xl font-semibold mb-6">Customer Reviews</h2>

            @if(auth()->check())
                <a href="{{ route('reviews.create', $product) }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg inline-block mb-8">
                    Write a Review
                </a>
            @endif

            @forelse($product->reviews as $review)
                <div class="border-b pb-6 mb-6">
                    <div class="flex justify-between">
                        <div>
                            <strong>{{ $review->user->name }}</strong>
                            @if($review->is_verified)
                                <span class="ml-2 text-green-600 text-sm">✅ Verified Buyer</span>
                            @endif
                        </div>
                        <div class="text-yellow-400">
                            @for($i=1; $i<=5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                    <p class="mt-3">{{ $review->comment }}</p>
                    @if($review->image)
                        <img src="{{ asset('storage/' . $review->image) }}" class="mt-4 max-w-xs rounded">
                    @endif
                </div>
            @empty
                <p>No reviews yet. Be the first to review!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection