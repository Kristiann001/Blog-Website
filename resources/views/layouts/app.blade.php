<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="navbar()" x-init="initTheme()">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nexus Insight')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function navbar() {
            return {
                open: false,
                scrolled: false,
                darkMode: false,
                scrollY: 0,

                initTheme() {
                    this.darkMode = localStorage.getItem('theme') === 'dark';
                    if (this.darkMode) document.documentElement.classList.add('dark');

                    window.addEventListener('scroll', () => {
                        this.scrolled = window.scrollY > 10;
                    });
                },

                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    document.documentElement.classList.toggle('dark', this.darkMode);
                },

                toggleMenu() {
                    this.open = !this.open;
                    if (this.open) {
                        this.scrollY = window.scrollY;
                        document.body.style.position = 'fixed';
                        document.body.style.top = `-${this.scrollY}px`;
                    } else {
                        document.body.style.position = '';
                        document.body.style.top = '';
                        window.scrollTo(0, this.scrollY);
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200">

<!-- Navbar -->
<nav 
    :class="scrolled 
        ? 'shadow-lg bg-white dark:bg-gray-900 backdrop-blur-sm' 
        : 'bg-white dark:bg-gray-900 shadow-none'"
    class="fixed w-full top-0 z-20 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center text-sm md:text-base">
        <h1 class="text-2xl font-black tracking-tight text-indigo-600 dark:text-indigo-400">
            Nexus<span class="text-gray-900 dark:text-white">Insight</span>
        </h1>

        <!-- Desktop Links -->
        <div class="hidden md:flex items-center space-x-8 font-medium">
            <!-- Left Links -->
            <ul class="flex space-x-6">
                <li>
                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 pb-1' : 'text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-b-2 hover:border-indigo-600 pb-1 transition-all duration-200' }}">
                       Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}"
                       class="{{ request()->routeIs('about') ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 pb-1' : 'text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-b-2 hover:border-indigo-600 pb-1 transition-all duration-200' }}">
                       About
                    </a>
                </li>
                <li>
                    <a href="{{ route('services') }}"
                       class="{{ request()->routeIs('services') ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 pb-1' : 'text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-b-2 hover:border-indigo-600 pb-1 transition-all duration-200' }}">
                       Services
                    </a>
                </li>
                <li>
                    <!-- <a href="@guest{{ route('publicblog.index') }}@else{{ route('user.blogs.index') }}@endguest"
                       class="{{ request()->routeIs('publicblog.*') || request()->routeIs('user.blogs.*') ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 pb-1' : 'text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-b-2 hover:border-indigo-600 pb-1 transition-all duration-200' }}">
                       Blogs
                    </a> -->
                    <a href="{{ route('publicblog.index') }}"
                    class="{{ request()->routeIs('publicblog.*') ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 pb-1' : 'text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-b-2 hover:border-indigo-600 pb-1 transition-all duration-200' }}">Blogs
                   </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}"
                       class="{{ request()->routeIs('contact') ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 pb-1' : 'text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-b-2 hover:border-indigo-600 pb-1 transition-all duration-200' }}">
                       Contact
                    </a>
                </li>
            </ul>

            <!-- Right Auth Links -->
            <div class="flex items-center space-x-3 ml-10">
                @auth
                    <div x-data="{ dropdown: false }" class="relative">
                        <button @click="dropdown = !dropdown" class="flex items-center space-x-1 bg-indigo-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-3 py-1.5 rounded-lg hover:bg-indigo-200 dark:hover:bg-gray-700 transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                                111.414 1.414l-4 4a1 1 0 
                                01-1.414 0l-4-4a1 1 0 
                                010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="dropdown" x-cloak @click.away="dropdown=false" class="absolute mt-2 right-0 w-40 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg py-2 z-50">
                            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : (Auth::user()->role === 'blogger' ? route('blogger.dashboard') : route('user.dashboard')) }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-1.5 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition font-semibold">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-1.5 bg-gray-800 dark:bg-indigo-400 text-white rounded-lg hover:bg-gray-700 dark:hover:bg-indigo-500 transition font-semibold">Register</a>
                @endauth
            </div>
        </div>

        <!-- Theme Toggle & Mobile Menu -->
        <div class="flex items-center space-x-4">
            <!-- Dark Mode -->
            <button @click="toggleDarkMode()" class="relative w-9 h-9 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-800 transition-all duration-500">
                <svg x-show="!darkMode" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-yellow-500 transition-transform duration-500 transform" :class="{ 'rotate-180 opacity-0': darkMode }">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m8.66-8.66h1M4.34 12.34H3m15.36 6.36l.7.7M5.64 5.64l.7.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <svg x-show="darkMode" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-indigo-400 transition-transform duration-500 transform" :class="{ 'rotate-180 opacity-0': !darkMode }">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
                </svg>
            </button>

            <!-- Mobile Menu Button -->
            <button @click="toggleMenu()" class="md:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-cloak x-transition.opacity @click="toggleMenu()" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-10 md:hidden"></div>
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0" class="fixed top-0 right-0 h-full w-3/4 sm:w-1/2 shadow-2xl z-20 flex flex-col border-l bg-white dark:bg-gray-900 transition-colors duration-300">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">Menu</h2>
            <button @click="toggleMenu()" class="text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <ul class="flex flex-col mt-6 space-y-5 px-6 font-medium">
            <li><a href="{{ route('home') }}" @click="toggleMenu()" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Home</a></li>
            <li><a href="{{ route('about') }}" @click="toggleMenu()" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">About</a></li>
            <li><a href="{{ route('services') }}" @click="toggleMenu()" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Services</a></li>
            <li><a href="{{ route('publicblog.index') }}" @click="toggleMenu()" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Blogs</a></li>
            <li><a href="{{ route('contact') }}" @click="toggleMenu()" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Contact</a></li>

            @auth
                <li class="pt-4 border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
                    <p class="mb-2">{{ Auth::user()->name }}</p>
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : (Auth::user()->role === 'blogger' ? route('blogger.dashboard') : route('user.dashboard')) }}" class="block w-full px-4 py-2 bg-indigo-100 dark:bg-gray-800 rounded-lg text-center hover:bg-indigo-200 dark:hover:bg-gray-700 transition">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-gray-800 dark:bg-indigo-500 text-white rounded-lg hover:bg-gray-700 dark:hover:bg-indigo-600 transition">Logout</button>
                    </form>
                </li>
            @else
                <li class="pt-4 border-t border-gray-200 dark:border-gray-700 flex flex-col space-y-3">
                    <a href="{{ route('login') }}" @click="toggleMenu()" class="w-full px-4 py-2 bg-indigo-500 text-white rounded-lg text-center hover:bg-indigo-600 transition font-semibold">Login</a>
                    <a href="{{ route('register') }}" @click="toggleMenu()" class="w-full px-4 py-2 bg-gray-800 dark:bg-indigo-400 text-white rounded-lg text-center hover:bg-gray-700 dark:hover:bg-indigo-500 transition font-semibold">Register</a>
                </li>
            @endauth
        </ul>
    </div>
</nav>

@if (session('error'))
    <div class="bg-red-500 text-white p-3 rounded-md mb-4">
        {{ session('error') }}
    </div>
@endif

<!-- Page Content -->
<main class="pt-28 md:pt-32">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 py-12 modern-footer">
    <div class="max-w-7xl mx-auto px-6 flex flex-col items-center">
        <h2 class="text-xl font-black tracking-tight text-indigo-600 dark:text-indigo-400 mb-4">
            NexusInsight
        </h2>
        <p class="text-gray-500 dark:text-gray-400 mb-6">Empowering minds through curated insights and innovation.</p>
        <div class="flex space-x-6 mb-8 text-gray-400">
            <a href="#" class="hover:text-indigo-600 transition">Twitter</a>
            <a href="#" class="hover:text-indigo-600 transition">LinkedIn</a>
            <a href="#" class="hover:text-indigo-600 transition">GitHub</a>
        </div>
        <p class="text-sm">© {{ date('Y') }} Nexus Insight. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
