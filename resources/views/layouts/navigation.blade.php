<nav class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-gray-800 dark:text-white">
                    ⭐ Product Reviews
                </a>
            </div>

            <!-- Menu -->
            <div class="flex items-center gap-6 text-sm">
                <a href="{{ route('products.index') }}" class="hover:text-blue-600">Products</a>
                <a href="{{ route('cart.index') }}" class="hover:text-blue-600">Cart</a>

                @guest
                    <a href="{{ route('login') }}" class="hover:text-blue-600 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                        Register
                    </a>
                @else
                    <a href="{{ route('my.orders') }}" class="hover:text-blue-600">My Orders</a>

                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="text-red-600 font-semibold">Admin Panel</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-red-600 font-medium">
                            Logout ({{ auth()->user()->name }})
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>