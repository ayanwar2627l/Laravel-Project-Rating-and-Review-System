@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">
    <a href="{{ route('products.show', $product) }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 text-sm mb-8 transition-colors">
        ← Back to product
    </a>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-violet-600 p-6">
            <h1 class="text-2xl font-bold text-white">Edit Product</h1>
            <p class="text-indigo-200 mt-1">{{ $product->name }}</p>
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

            <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                    <select name="category_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300 resize-none" required>{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Price (₹)</label>
                        <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Product Image</label>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover rounded-xl mb-3 border border-slate-200">
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none">
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded">
                    <label for="is_active" class="text-sm font-medium text-slate-700">Active (visible to customers)</label>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition-colors">
                        Save Changes
                    </button>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete this product permanently?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-rose-50 border border-rose-200 text-rose-700 font-semibold rounded-xl hover:bg-rose-100 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
