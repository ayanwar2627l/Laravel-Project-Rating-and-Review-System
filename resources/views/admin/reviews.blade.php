@extends('layouts.app')
@section('title', 'Manage Reviews')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Review Management</h1>
            <p class="text-slate-500 mt-1">Review, approve or remove customer feedback</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">
            ← Dashboard
        </a>
    </div>

    @if($reviews->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center shadow-sm">
            <div class="text-5xl mb-4">💬</div>
            <p class="text-slate-500 text-lg">No reviews to display yet.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($reviews as $review)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">

                        <!-- Review info -->
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-700 text-sm">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="font-semibold text-slate-800">{{ $review->user->name }}</span>
                                    <span class="text-slate-400 text-xs ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex text-amber-400 text-sm ml-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}">★</span>
                                    @endfor
                                </div>
                                @if($review->is_verified)
                                    <span class="text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full">✓ Verified</span>
                                @endif
                                @if(!$review->is_approved)
                                    <span class="text-xs bg-amber-50 text-amber-700 border border-amber-200 px-2 py-0.5 rounded-full">Pending</span>
                                @endif
                            </div>

                            <p class="text-xs text-indigo-600 font-medium mb-1">
                                Product: <a href="{{ route('products.show', $review->product) }}" class="hover:underline">{{ $review->product->name }}</a>
                            </p>
                            @if($review->title)
                                <p class="font-semibold text-slate-800 mb-1">{{ $review->title }}</p>
                            @endif
                            <p class="text-slate-600 text-sm">{{ Str::limit($review->comment, 200) }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if(!$review->is_approved)
                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                    @csrf
                                    <button type="submit"
                                            class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-100 transition-colors">
                                        ✓ Approve
                                    </button>
                                </form>
                            @else
                                <span class="text-xs bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-2 rounded-lg">Approved</span>
                            @endif

                            <form method="POST" action="{{ route('admin.reviews.delete', $review) }}"
                                  onsubmit="return confirm('Delete this review permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-rose-50 border border-rose-200 text-rose-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-rose-100 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection
