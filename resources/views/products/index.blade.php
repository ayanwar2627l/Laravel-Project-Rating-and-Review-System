@extends('layouts.app')
@section('title', 'All Products')

@section('content')

<!-- Hero -->
<section class="bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
            Discover Honest Reviews
        </h1>
        <p class="text-indigo-200 text-lg md:text-xl mb-10 max-w-2xl mx-auto">
            Browse thousands of products rated by real buyers. Make smarter purchase decisions.
        </p>

        <!-- Search bar -->
        <form method="GET" action="{{ route('products.index') }}" class="max-w-2xl mx-auto flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search for products…"
                class="flex-1 rounded-xl px-5 py-3 text-slate-800 text-base focus:outline-none focus:ring-2 focus:ring-white shadow-lg"
            >
            <button type="submit" class="bg-white text-indigo-700 font-semibold px-6 py-3 rounded-xl hover:bg-indigo-50 transition-colors shadow-lg">
                Search
            </button>
        </form>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Filters row -->
    <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-3 mb-8 items-center">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <select name="category" onchange="this.form.submit()"
            class="border border-slate-200 rounded-lg px-4 py-2.5 text-sm bg-white shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <select name="sort" onchange="this.form.submit()"
            class="border border-slate-200 rounded-lg px-4 py-2.5 text-sm bg-white shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none">
            <option value="newest"    {{ request('sort', 'newest') == 'newest'     ? 'selected' : '' }}>Newest</option>
            <option value="rating"    {{ request('sort') == 'rating'     ? 'selected' : '' }}>Top Rated</option>
            <option value="price_asc" {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc"{{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
        </select>

        @if(request()->anyFilled(['search','category','sort']))
            <a href="{{ route('products.index') }}" class="text-sm text-slate-500 hover:text-rose-600 transition-colors">
                ✕ Clear filters
            </a>
        @endif

        <span class="ml-auto text-sm text-slate-500">{{ $products->total() }} products found</span>
    </form>

    <!-- Product grid -->
    @if($products->isEmpty())
        <div class="text-center py-24">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-xl font-semibold text-slate-700 mb-2">No products found</h3>
            <p class="text-slate-500">Try adjusting your search or filters.</p>
            <a href="{{ route('products.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline">View all products</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <a href="{{ route('products.show', $product) }}"
               class="group bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col">

                <!-- Image -->
                <div class="relative aspect-square bg-slate-100 overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-5xl">📦</div>
                    @endif
                    @if($product->average_rating >= 4.5)
                        <span class="absolute top-2 left-2 bg-amber-400 text-amber-900 text-xs font-bold px-2 py-0.5 rounded-full">
                            Top Rated
                        </span>
                    @endif
                </div>

                <!-- Info -->
                <div class="p-4 flex flex-col flex-1">
                    <p class="text-xs text-indigo-600 font-medium mb-1">{{ $product->category->name ?? 'General' }}</p>
                    <h3 class="font-semibold text-slate-800 text-sm leading-snug mb-2 group-hover:text-indigo-700 transition-colors line-clamp-2">
                        {{ $product->name }}
                    </h3>

                    <!-- Stars -->
                    <div class="flex items-center gap-1.5 mb-3">
                        <div class="flex text-amber-400 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->average_rating))
                                    <span>★</span>
                                @elseif($i - $product->average_rating < 1 && $i - $product->average_rating > 0)
                                    <span class="text-amber-300">★</span>
                                @else
                                    <span class="text-slate-200">★</span>
                                @endif
                            @endfor
                        </div>
                        <span class="text-xs text-slate-500">{{ number_format($product->average_rating, 1) }} ({{ $product->review_count }})</span>
                    </div>

                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-lg font-bold text-indigo-700">₹{{ number_format($product->price, 0) }}</span>
                        <span class="text-xs text-slate-400">{{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
