<nav x-data="{ mobileMenuOpen: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Branding -->
            <div class="flex items-center space-x-6 uppercase text-[9px] font-bold tracking-[0.4em] text-gray-400">
                <a href="{{ route('blog.index') }}" class="text-gray-900 border-b-2 border-cyan-500 pb-1 brand-font tracking-tighter text-lg lowercase first-letter:uppercase">Zenith Stories</a>
            </div>
            
            <!-- Desktop Categories -->
            <div class="hidden md:flex space-x-10 uppercase text-[10px] font-bold tracking-[0.3em] text-gray-500">
                @foreach($categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}" 
                       class="hover:text-cyan-500 transition {{ request('category') == $category->slug ? 'text-cyan-500' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Desktop Auth & Hamburger -->
            <div class="flex items-center space-x-6 text-gray-400">
                @auth
                    <a href="{{ route('dashboard') }}" class="hidden md:inline-block text-cyan-500 uppercase text-[10px] font-bold tracking-widest border border-cyan-500/20 px-4 py-2 rounded-full hover:bg-cyan-500 hover:text-white transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hidden md:inline-block hover:text-cyan-500 uppercase text-[10px] font-bold tracking-widest">Login</a>
                    <a href="{{ route('register') }}" class="hidden md:inline-block bg-gray-900 text-white uppercase text-[10px] font-bold tracking-widest px-6 py-2 rounded-full hover:bg-cyan-500 transition">Join</a>
                @endauth

                <!-- Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-900 p-2 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         x-cloak
         class="md:hidden bg-white border-t border-gray-100 shadow-xl pb-6">
        <div class="px-4 py-6 space-y-4">
            <p class="text-[9px] uppercase tracking-[0.3em] text-gray-400 font-bold mb-4">Categories</p>
            @foreach($categories as $category)
                <a href="{{ route('blog.index', ['category' => $category->slug]) }}" 
                   class="block text-sm font-bold text-gray-700 hover:text-cyan-500 transition uppercase tracking-widest">
                    {{ $category->name }}
                </a>
            @endforeach

            <div class="pt-6 border-t border-gray-50 flex flex-col space-y-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="block text-center text-cyan-500 uppercase text-[10px] font-bold tracking-widest border border-cyan-500/20 px-4 py-3 rounded-full hover:bg-cyan-500 hover:text-white transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block text-center text-gray-500 uppercase text-[10px] font-bold tracking-widest py-3">Login</a>
                    <a href="{{ route('register') }}" class="block text-center bg-gray-900 text-white uppercase text-[10px] font-bold tracking-widest px-6 py-3 rounded-full hover:bg-cyan-500 transition">Get Started</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
