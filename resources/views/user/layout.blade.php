<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="layout()" 
      x-init="initTheme()" 
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen flex flex-col">

<script>
function layout() {
    return {
        darkMode: false,
        initTheme() {
            this.darkMode = localStorage.getItem('theme') === 'dark';
        },
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        }
    }
}
</script>

{{-- Navbar --}}
<nav class="bg-white dark:bg-gray-800 shadow px-6 py-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">

        {{-- Left Links --}}
<div class="flex items-center space-x-6">
    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">MyBlogSite</a>
    <a href="{{ route('home') }}" 
       class="{{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-500' }}">
       Home
    </a>
    <a href="{{ route('publicblog.index') }}" 
       class="{{ request()->routeIs('publicblog.*') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-500' }}">
       Blogs
    </a>

    @auth
        @php
            $dashboardRoute = match(Auth::user()->role) {
                'admin' => route('admin.dashboard'),
                'blogger' => route('blogger.dashboard'),
                default => route('user.dashboard'),
            };
        @endphp
        <a href="{{ $dashboardRoute }}" 
           class="{{ request()->routeIs('admin.dashboard', 'blogger.dashboard', 'user.dashboard') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-500' }}">
           Dashboard
        </a>
    @endauth
</div>

        {{-- Right Links --}}
        <div class="flex items-center space-x-4">
            {{-- Dark Mode Toggle --}}
            <button @click="toggleDarkMode()" 
                    class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a1 1 0 010 2A6 6 0 104 10a1 1 0 01-2 0A8 8 0 1010 2z" />
                </svg>
                <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
            </button>

            {{-- Auth Links --}}
            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 bg-indigo-600 text-white px-3 py-2 rounded-lg hover:bg-indigo-500">
                        <span>{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden z-20">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" 
                   class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition font-semibold">
                   Login
                </a>
                <a href="{{ route('register') }}" 
                   class="px-4 py-2 bg-gray-800 dark:bg-indigo-400 text-white rounded-lg hover:bg-gray-700 dark:hover:bg-indigo-500 transition font-semibold">
                   Register
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- Page Content --}}
<main class="flex-1 p-6">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="text-center py-6 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 mt-auto">
    <p>&copy; {{ date('Y') }} MyBlogSite. All rights reserved.</p>
</footer>

</body>
</html>
