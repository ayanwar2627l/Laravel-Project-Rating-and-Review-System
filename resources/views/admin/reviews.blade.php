@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">All Reviews Management</h1>
    <!-- Simple table of reviews with Approve/Delete buttons -->
    @foreach($reviews as $review)
        <div class="border p-4 mb-4">
            <p><strong>{{ $review->user->name }}</strong> on <strong>{{ $review->product->name }}</strong></p>
            <p>Rating: {{ $review->rating }} ★</p>
            <p>{{ $review->comment }}</p>
            <div class="mt-3">
                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.reviews.delete', $review) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection