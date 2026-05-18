@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-400 mb-6 flex items-center gap-2">
        <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition-colors">Products</a>
        <span>/</span>
        <span class="text-slate-600">{{ $product->name }}</span>
    </nav>

    <!-- Product Top Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-16">

        <!-- Image -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden aspect-square shadow-sm flex items-center justify-center">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="text-8xl">📦</div>
            @endif
        </div>

        <!-- Details -->
        <div class="flex flex-col justify-center">
            <span class="inline-block bg-indigo-50 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full mb-3 w-fit">
                {{ $product->category->name ?? 'General' }}
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 mb-4 leading-tight">{{ $product->name }}</h1>

            <!-- Rating summary -->
            <div class="flex items-center gap-3 mb-6">
                <div class="flex items-center gap-1 text-amber-400 text-xl">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($product->average_rating))
                            <span>★</span>
                        @else
                            <span class="text-slate-200">★</span>
                        @endif
                    @endfor
                </div>
                <span class="text-slate-700 font-semibold">{{ number_format($product->average_rating, 1) }}</span>
                <span class="text-slate-400 text-sm">{{ $product->review_count }} {{ Str::plural('review', $product->review_count) }}</span>
            </div>

            <p class="text-slate-600 leading-relaxed mb-8">{{ $product->description }}</p>

            <div class="text-4xl font-extrabold text-indigo-700 mb-2">₹{{ number_format($product->price, 0) }}</div>
            <p class="text-sm {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }} font-medium mb-6">
                {{ $product->stock > 0 ? "✓ In stock ({$product->stock} available)" : '✕ Out of stock' }}
            </p>

            <div class="flex flex-wrap gap-3">
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl transition-colors shadow-sm">
                            Add to Cart 🛒
                        </button>
                    </form>
                @endif

                @auth
                    <a href="{{ route('reviews.create', $product) }}"
                       class="bg-amber-50 border border-amber-300 text-amber-800 font-semibold px-6 py-3 rounded-xl hover:bg-amber-100 transition-colors">
                        ★ Write a Review
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="bg-slate-100 border border-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl hover:bg-slate-200 transition-colors">
                        Sign in to review
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Rating Breakdown + Reviews -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- Rating breakdown -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-24">
                <h2 class="text-lg font-bold text-slate-800 mb-5">Rating Breakdown</h2>

                <div class="text-center mb-6">
                    <div class="text-6xl font-extrabold text-indigo-700">{{ number_format($product->average_rating, 1) }}</div>
                    <div class="flex justify-center gap-1 text-amber-400 text-xl mt-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($product->average_rating))
                                <span>★</span>
                            @else
                                <span class="text-slate-200">★</span>
                            @endif
                        @endfor
                    </div>
                    <p class="text-slate-400 text-sm mt-1">out of 5 stars</p>
                </div>

                <div class="space-y-2">
                    @for($star = 5; $star >= 1; $star--)
                        @php
                            $count = $ratingCounts[$star] ?? 0;
                            $pct   = $product->review_count > 0 ? round(($count / $product->review_count) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-slate-600 w-4">{{ $star }}</span>
                            <span class="text-amber-400 text-xs">★</span>
                            <div class="flex-1 bg-slate-100 rounded-full h-2">
                                <div class="bg-amber-400 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="text-slate-400 w-6 text-right">{{ $count }}</span>
                        </div>
                    @endfor
                </div>

                @auth
                    <a href="{{ route('reviews.create', $product) }}"
                       class="mt-6 w-full block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition-colors">
                        Write a Review
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="mt-6 w-full block text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 rounded-xl transition-colors">
                        Sign in to review
                    </a>
                @endauth
            </div>
        </div>

        <!-- Reviews list -->
        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold text-slate-800 mb-6">
                Customer Reviews
                <span class="text-slate-400 font-normal text-base ml-2">({{ $product->review_count }})</span>
            </h2>

            @forelse($product->reviews as $review)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-4 shadow-sm">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-700 text-sm">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-slate-800 text-sm">{{ $review->user->name }}</div>
                                <div class="text-xs text-slate-400">{{ $review->created_at->format('M j, Y') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="flex text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}">★</span>
                                @endfor
                            </div>
                            @if($review->is_verified)
                                <span class="text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full font-medium">
                                    ✓ Verified
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($review->title)
                        <h4 class="font-semibold text-slate-800 mb-2">{{ $review->title }}</h4>
                    @endif
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $review->comment }}</p>

                    @if($review->image)
                        <img src="{{ asset('storage/' . $review->image) }}"
                             alt="Review image"
                             class="mt-4 rounded-xl max-w-sm border border-slate-200">
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                    <div class="text-5xl mb-4">💬</div>
                    <h3 class="text-slate-700 font-semibold text-lg mb-2">No reviews yet</h3>
                    <p class="text-slate-400 mb-6">Be the first to share your experience with this product.</p>
                    @auth
                        <a href="{{ route('reviews.create', $product) }}"
                           class="inline-block bg-indigo-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-indigo-700 transition-colors">
                            Write the first review
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-block bg-indigo-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-indigo-700 transition-colors">
                            Sign in to review
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
