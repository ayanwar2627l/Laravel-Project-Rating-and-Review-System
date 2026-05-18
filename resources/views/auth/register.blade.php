<x-guest-layout>
    <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-6">
        <h1 class="text-2xl font-bold text-white">Create your account</h1>
        <p class="text-indigo-200 text-sm mt-1">Join RateIt and start reviewing products</p>
    </div>

    <div class="px-8 py-6">
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Full Name')" class="text-sm font-semibold text-slate-700 block mb-2" />
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-rose-500 text-xs" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email Address')" class="text-sm font-semibold text-slate-700 block mb-2" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-500 text-xs" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-slate-700 block mb-2" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-500 text-xs" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-slate-700 block mb-2" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-rose-500 text-xs" />
            </div>

            <x-primary-button class="w-full">Create Account</x-primary-button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Sign in</a>
        </p>
    </div>
</x-guest-layout>
