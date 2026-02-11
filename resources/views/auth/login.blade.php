<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold uppercase tracking-widest text-gray-800">Login</h2>
            <p class="text-xs text-gray-500 mt-2 uppercase tracking-tight">Welcome back to the blog</p>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Email address</label>
            <input id="email" class="block w-full px-4 py-3 bg-white/50 border border-gray-100 rounded-xl focus:outline-none focus:border-cyan-500 transition text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Password</label>
            <input id="password" class="block w-full px-4 py-3 bg-white/50 border border-gray-100 rounded-xl focus:outline-none focus:border-cyan-500 transition text-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500" name="remember">
                <span class="ms-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-[10px] font-bold uppercase tracking-widest text-cyan-500 hover:text-gray-900 transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-xl text-[10px] uppercase tracking-[0.3em] hover:bg-cyan-500 transition-all shadow-xl">
                {{ __('Log in') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                Don't have an account? <a href="{{ route('register') }}" class="text-cyan-500 hover:underline">Register now</a>
            </p>
        </div>
    </form>
</x-guest-layout>
