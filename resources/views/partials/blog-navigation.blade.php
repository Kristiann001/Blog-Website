<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-xl border-b border-gray-200/60 sticky top-0 z-[60] shadow-[0_1px_3px_rgba(0,0,0,0.04)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[72px]">

            {{-- Logo --}}
            <a href="{{ route('blog.index') }}" class="flex items-center space-x-2 flex-shrink-0">
                <span class="brand-font text-2xl lg:text-[26px] font-bold text-gray-900 tracking-tight">Zenith<span class="text-cyan-500">.</span></span>
            </a>

            {{-- Desktop: center nav links --}}
            <div class="hidden lg:flex items-center space-x-8 xl:space-x-10">
                <a href="{{ route('blog.index') }}"
                   class="text-[11px] font-semibold uppercase tracking-[0.15em] {{ request()->routeIs('blog.index') && !request('category') ? 'text-cyan-600' : 'text-gray-500 hover:text-gray-900' }} transition-colors duration-200">
                    Home
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                       class="text-[11px] font-semibold uppercase tracking-[0.15em] {{ request('category') == $category->slug ? 'text-cyan-600' : 'text-gray-500 hover:text-gray-900' }} transition-colors duration-200">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            {{-- Desktop: right actions --}}
            <div class="hidden lg:flex items-center space-x-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-600 hover:text-gray-900 transition-colors px-4 py-2">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-[11px] font-semibold uppercase tracking-[0.12em] bg-gray-900 text-white px-5 py-2.5 rounded-lg hover:bg-red-600 transition-colors duration-200">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-600 hover:text-gray-900 transition-colors px-4 py-2">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-[11px] font-semibold uppercase tracking-[0.12em] bg-gray-900 text-white px-5 py-2.5 rounded-lg hover:bg-cyan-600 transition-colors duration-200">
                        Get Started
                    </a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button @click="open = !open"
                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition"
                    aria-label="Toggle menu">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile dropdown --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         x-cloak
         class="lg:hidden bg-white border-t border-gray-100 shadow-lg">

        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('blog.index') }}"
               @click="open = false"
               class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('blog.index') && !request('category') ? 'bg-cyan-50 text-cyan-700' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <i class="fas fa-home w-5 mr-2 text-center"></i> Home
            </a>

            @foreach($categories as $category)
                <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                   @click="open = false"
                   class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ request('category') == $category->slug ? 'bg-cyan-50 text-cyan-700' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                    <i class="fas fa-tag w-5 mr-2 text-center text-xs"></i> {{ $category->name }}
                </a>
            @endforeach
        </div>

        <div class="border-t border-gray-100 px-4 py-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   @click="open = false"
                   class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-th-large w-5 mr-2 text-center text-xs"></i> Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fas fa-sign-out-alt w-5 mr-2 text-center text-xs"></i> Log Out
                    </button>
                </form>
            @else
                <div class="flex space-x-2">
                    <a href="{{ route('login') }}"
                       @click="open = false"
                       class="flex-1 text-center px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 border border-gray-200 hover:bg-gray-50 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       @click="open = false"
                       class="flex-1 text-center px-3 py-2.5 rounded-lg text-sm font-semibold text-white bg-gray-900 hover:bg-cyan-600 transition-colors">
                        Get Started
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
