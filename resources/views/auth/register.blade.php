<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold uppercase tracking-widest text-gray-800">Register</h2>
            <p class="text-xs text-gray-500 mt-2 uppercase tracking-tight">Join our creative journey</p>
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Full name</label>
            <input id="name" class="block w-full px-4 py-3 bg-white/50 border border-gray-100 rounded-xl focus:outline-none focus:border-cyan-500 transition text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Email address</label>
            <input id="email" class="block w-full px-4 py-3 bg-white/50 border border-gray-100 rounded-xl focus:outline-none focus:border-cyan-500 transition text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Password</label>
            <input id="password" class="block w-full px-4 py-3 bg-white/50 border border-gray-100 rounded-xl focus:outline-none focus:border-cyan-500 transition text-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Confirm Password</label>
            <input id="password_confirmation" class="block w-full px-4 py-3 bg-white/50 border border-gray-100 rounded-xl focus:outline-none focus:border-cyan-500 transition text-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-xl text-[10px] uppercase tracking-[0.3em] hover:bg-cyan-500 transition-all shadow-xl">
                {{ __('Register') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                Already have an account? <a href="{{ route('login') }}" class="text-cyan-500 hover:underline">Log in now</a>
            </p>
        </div>
    </form>
</x-guest-layout>
