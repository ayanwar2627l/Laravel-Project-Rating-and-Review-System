@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 max-w-2xl">
    <h1 class="text-3xl font-bold mb-8">Create New Product</h1>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block font-medium mb-2">Product Name</label>
            <input type="text" name="name" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-4" required>
        </div>

        <div>
            <label class="block font-medium mb-2">Category</label>
            <select name="category_id" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-4" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium mb-2">Description</label>
            <textarea name="description" rows="5" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-4" required></textarea>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block font-medium mb-2">Price (₹)</label>
                <input type="number" name="price" step="0.01" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-4" required>
            </div>
            <div>
                <label class="block font-medium mb-2">Stock</label>
                <input type="number" name="stock" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-4" required>
            </div>
        </div>

        <div>
            <label class="block font-medium mb-2">Product Image</label>
            <input type="file" name="image" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-4">
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-4 rounded-lg">
            Create Product
        </button>
    </form>
</div>
@endsection