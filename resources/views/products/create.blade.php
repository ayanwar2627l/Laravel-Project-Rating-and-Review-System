@extends('layouts.app')
@section('title', 'Add New Product')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">
    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 text-sm mb-8 transition-colors">
        ← Back to products
    </a>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-violet-600 p-6">
            <h1 class="text-2xl font-bold text-white">Add New Product</h1>
            <p class="text-indigo-200 mt-1">Create a new product listing</p>
        </div>

        <div class="p-8">
            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 rounded-xl px-4 py-3 mb-6">
                    <ul class="text-rose-700 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Product Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g. Sony WH-1000XM5 Headphones"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Category <span class="text-rose-500">*</span></label>
                    <select name="category_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Description <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="5"
                              placeholder="Describe the product features, specifications, and benefits…"
                              class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300 resize-none" required>{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Price (₹) <span class="text-rose-500">*</span></label>
                        <input type="number" name="price" step="0.01" value="{{ old('price') }}"
                               placeholder="0.00"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Stock <span class="text-rose-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock') }}"
                               placeholder="0"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Product Image</label>
                    <label class="flex items-center gap-3 border-2 border-dashed border-slate-200 rounded-xl px-4 py-4 cursor-pointer hover:border-indigo-300 hover:bg-indigo-50 transition-colors">
                        <span class="text-2xl">🖼️</span>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Upload an image</p>
                            <p class="text-xs text-slate-400">JPEG, PNG up to 2MB</p>
                        </div>
                        <input type="file" name="image" accept="image/*" class="hidden">
                    </label>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition-colors shadow-sm">
                    Create Product
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
