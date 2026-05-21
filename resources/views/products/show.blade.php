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
            <div class="flex items-center gap-3 mb-3">
                <div class="flex items-center gap-0.5 text-amber-400 text-xl">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= floor($product->average_rating) ? 'text-amber-400' : 'text-slate-200' }}">★</span>
                    @endfor
                </div>
                <span class="text-slate-700 font-semibold">{{ number_format($product->average_rating, 1) }}</span>
                <span class="text-slate-400 text-sm">{{ $product->review_count }} {{ Str::plural('review', $product->review_count) }}</span>
                @php $verifiedCount = $reviews->where('is_verified', true)->count(); @endphp
                @if($verifiedCount > 0)
                    <span class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                        ✓ {{ $verifiedCount }} verified
                    </span>
                @endif
            </div>

            @if($hasPurchased)
                <div class="inline-flex items-center gap-1.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-3 py-1.5 rounded-lg mb-4 w-fit">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    You purchased this product — your review will be Verified
                </div>
            @endif

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
                    <div class="flex justify-center gap-0.5 text-amber-400 text-xl mt-2">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($product->average_rating) ? 'text-amber-400' : 'text-slate-200' }}">★</span>
                        @endfor
                    </div>
                    <p class="text-slate-400 text-sm mt-1">out of 5 · {{ $product->review_count }} {{ Str::plural('review', $product->review_count) }}</p>
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
                            <span class="text-slate-400 w-6 text-right text-xs">{{ $count }}</span>
                        </div>
                    @endfor
                </div>

                <div class="mt-5 pt-5 border-t border-slate-100">
                    @php $verifiedPct = $product->review_count > 0 ? round(($reviews->where('is_verified',true)->count() / $product->review_count) * 100) : 0; @endphp
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-slate-500">Verified Purchases</span>
                        <span class="text-emerald-700 font-semibold">{{ $verifiedPct }}%</span>
                    </div>
                    <div class="bg-slate-100 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $verifiedPct }}%"></div>
                    </div>
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

            <!-- Reviews header + sort -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <h2 class="text-xl font-bold text-slate-800">
                    Customer Reviews
                    <span class="text-slate-400 font-normal text-base ml-2">({{ $product->review_count }})</span>
                </h2>

                <form method="GET" action="{{ route('products.show', $product) }}" class="flex items-center gap-2">
                    <label class="text-sm text-slate-500 font-medium">Sort by:</label>
                    <select name="review_sort" onchange="this.form.submit()"
                            class="text-sm border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white text-slate-700">
                        <option value="verified"  {{ $reviewSort === 'verified'  ? 'selected' : '' }}>✓ Verified first</option>
                        <option value="newest"    {{ $reviewSort === 'newest'    ? 'selected' : '' }}>Newest first</option>
                        <option value="highest"   {{ $reviewSort === 'highest'   ? 'selected' : '' }}>Highest rated</option>
                        <option value="lowest"    {{ $reviewSort === 'lowest'    ? 'selected' : '' }}>Lowest rated</option>
                    </select>
                </form>
            </div>

            @forelse($reviews as $review)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-4 shadow-sm
                    {{ $review->is_verified ? 'border-l-4 border-l-emerald-400' : '' }}">

                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-700 text-sm flex-shrink-0">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-slate-800 text-sm">{{ $review->user->name }}</div>
                                <div class="text-xs text-slate-400">{{ $review->created_at->format('M j, Y') }}</div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1.5">
                            <div class="flex items-center gap-0.5 text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-sm {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}">★</span>
                                @endfor
                            </div>
                            @if($review->is_verified)
                                <span class="text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full font-medium flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Verified Buyer
                                </span>
                            @else
                                <span class="text-xs text-slate-400 border border-slate-200 px-2 py-0.5 rounded-full">
                                    Unverified
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
