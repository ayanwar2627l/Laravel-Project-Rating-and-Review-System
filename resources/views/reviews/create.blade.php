@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Write Review for {{ $product->name }}</h1>

    @if($existingReview)
        <p class="text-yellow-600 mb-4">You have already reviewed this product. You can update it below.</p>
    @endif

    <form method="POST" action="{{ route('reviews.store', $product) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-lg font-medium mb-2">Rating</label>
            <div class="flex gap-2 text-4xl">
                @for($i = 1; $i <= 5; $i++)
                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="hidden peer" required>
                    <label for="star{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-yellow-400">★</label>
                @endfor
            </div>
        </div>

        <div class="mb-4">
            <label>Title (Optional)</label>
            <input type="text" name="title" class="w-full border p-3 rounded" placeholder="Review title">
        </div>

        <div class="mb-4">
            <label>Comment</label>
            <textarea name="comment" rows="5" class="w-full border p-3 rounded" required></textarea>
        </div>

        <div class="mb-6">
            <label>Upload Photo (Optional)</label>
            <input type="file" name="image" class="w-full border p-3 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg">
            Submit Review
        </button>
    </form>
</div>
@endsection