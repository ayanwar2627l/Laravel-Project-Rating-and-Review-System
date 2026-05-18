<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RateIt') }} — @yield('title', 'Product Reviews')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-2xl">⭐</span>
                    <span class="text-xl font-bold text-indigo-700 tracking-tight">RateIt</span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('products.index') }}" class="text-slate-600 hover:text-indigo-700 transition-colors">Products</a>

                    @auth
                        <a href="{{ route('cart.index') }}" class="text-slate-600 hover:text-indigo-700 transition-colors relative">
                            🛒 Cart
                            @php $cartCount = count(session()->get('cart', [])) @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-3 bg-indigo-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('my.orders') }}" class="text-slate-600 hover:text-indigo-700 transition-colors">My Orders</a>

                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="bg-rose-50 text-rose-700 border border-rose-200 px-3 py-1.5 rounded-lg hover:bg-rose-100 transition-colors text-xs font-semibold">
                                Admin Panel
                            </a>
                        @endif

                        <div class="flex items-center gap-3">
                            <span class="text-slate-500 text-sm">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-slate-500 hover:text-rose-600 transition-colors text-sm">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-700 transition-colors">Sign in</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                            Get started
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button x-data @click="$dispatch('toggle-mobile-menu')" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" x-cloak
             class="md:hidden border-t border-slate-200 bg-white px-4 py-4 space-y-3 text-sm font-medium">
            <a href="{{ route('products.index') }}" class="block text-slate-600 hover:text-indigo-700">Products</a>
            @auth
                <a href="{{ route('cart.index') }}" class="block text-slate-600 hover:text-indigo-700">Cart</a>
                <a href="{{ route('my.orders') }}" class="block text-slate-600 hover:text-indigo-700">My Orders</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="block text-rose-700 font-semibold">Admin Panel</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-rose-600">Sign out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-slate-600 hover:text-indigo-700">Sign in</a>
                <a href="{{ route('register') }}" class="block text-indigo-700 font-semibold">Register</a>
            @endauth
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-800">✕</button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-xl px-4 py-3">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">⭐</span>
                    <span class="font-bold text-indigo-700">RateIt</span>
                    <span class="text-slate-400 text-sm ml-2">Online Product Rating & Review System</span>
                </div>
                <p class="text-slate-400 text-sm">© {{ date('Y') }} RateIt. Built with Laravel &amp; Tailwind CSS.</p>
            </div>
        </div>
    </footer>

</body>
</html>
