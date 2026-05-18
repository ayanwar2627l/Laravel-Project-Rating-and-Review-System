<x-guest-layout>
    <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-6">
        <h1 class="text-2xl font-bold text-white">Welcome back</h1>
        <p class="text-indigo-200 text-sm mt-1">Sign in to your RateIt account</p>
    </div>

    <div class="px-8 py-6">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email Address')" class="text-sm font-semibold text-slate-700 block mb-2" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-500 text-xs" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-slate-700 block mb-2" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-500 text-xs" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
                @endif
            </div>

            <x-primary-button class="w-full">Sign In</x-primary-button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Create one</a>
        </p>
    </div>
</x-guest-layout>
