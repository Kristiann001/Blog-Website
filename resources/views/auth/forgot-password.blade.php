<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold uppercase tracking-widest text-gray-800">Forgot Password</h2>
        <p class="text-xs text-gray-500 mt-2 uppercase tracking-tight">No worries, we'll help you out</p>
    </div>

    <div class="mb-6 text-[10px] font-bold uppercase tracking-widest text-gray-400 leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Email address</label>
            <input id="email" class="block w-full px-4 py-3 bg-white/50 border border-gray-100 rounded-xl focus:outline-none focus:border-cyan-500 transition text-sm" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-xl text-[10px] uppercase tracking-[0.3em] hover:bg-cyan-500 transition-all shadow-xl">
                {{ __('Email Reset Link') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-cyan-500 transition">
                &larr; Back to Log in
            </a>
        </div>
    </form>
</x-guest-layout>
