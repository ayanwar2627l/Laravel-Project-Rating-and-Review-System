@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900">Admin Dashboard</h1>
        <p class="text-slate-500 mt-1">Manage your product review platform</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        @php
            $totalProducts = \App\Models\Product::count();
            $totalReviews  = \App\Models\Review::count();
            $pendingReviews = \App\Models\Review::where('is_approved', false)->count();
            $totalUsers    = \App\Models\User::where('is_admin', false)->count();
        @endphp
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-sm text-slate-500 font-medium">Total Products</p>
            <p class="text-4xl font-extrabold text-indigo-700 mt-1">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-sm text-slate-500 font-medium">Total Reviews</p>
            <p class="text-4xl font-extrabold text-amber-600 mt-1">{{ $totalReviews }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-sm text-slate-500 font-medium">Pending Approval</p>
            <p class="text-4xl font-extrabold text-rose-600 mt-1">{{ $pendingReviews }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-sm text-slate-500 font-medium">Registered Users</p>
            <p class="text-4xl font-extrabold text-emerald-600 mt-1">{{ $totalUsers }}</p>
        </div>
    </div>

    <!-- Quick actions -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ route('admin.reviews') }}"
           class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-2xl">📝</div>
            <div>
                <p class="font-semibold text-slate-800">Manage Reviews</p>
                <p class="text-sm text-slate-400">Approve or remove reviews</p>
            </div>
        </a>
        <a href="{{ route('products.index') }}"
           class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-2xl">📦</div>
            <div>
                <p class="font-semibold text-slate-800">Browse Products</p>
                <p class="text-sm text-slate-400">View the product catalog</p>
            </div>
        </a>
        <a href="{{ route('products.create') }}"
           class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-2xl">➕</div>
            <div>
                <p class="font-semibold text-slate-800">Add Product</p>
                <p class="text-sm text-slate-400">Create a new product listing</p>
            </div>
        </a>
    </div>
</div>
@endsection
