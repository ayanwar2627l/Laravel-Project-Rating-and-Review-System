@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold">Admin Dashboard</h1>
    <p class="mt-4">Welcome Admin! Total Products: {{ \App\Models\Product::count() }}</p>
    <a href="{{ route('admin.reviews') }}" class="bg-red-600 text-white px-6 py-3 mt-6 inline-block rounded">Manage Reviews</a>
</div>
@endsection