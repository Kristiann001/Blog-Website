<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="navbar()" x-init="initTheme()">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blogger Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' };
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
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

<!-- Navbar -->
<nav :class="scrolled 
        ? 'shadow-lg bg-white dark:bg-gray-900 backdrop-blur-sm' 
        : 'bg-white dark:bg-gray-900 shadow-none'"
    class="fixed w-full top-0 z-20 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">Blogger Panel</h1>

        <!-- Links -->
        <div class="hidden md:flex items-center space-x-6 font-medium">
            <a href="{{ route('blogger.dashboard') }}"
               class="{{ request()->routeIs('blogger.dashboard') ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 pb-1' : 'text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-b-2 hover:border-indigo-600 pb-1 transition-all duration-200' }}">
               Dashboard
            </a>

            <a href="{{ route('blogger.blogs.index') }}"
               class="{{ request()->routeIs('blogger.blogs.*') ? 'text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 pb-1' : 'text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-b-2 hover:border-indigo-600 pb-1 transition-all duration-200' }}">
               All Blogs
            </a>

            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
               Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>

        <!-- Mobile Menu Button -->
        <div class="flex items-center md:hidden">
            <button @click="toggleMenu()" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-cloak class="fixed inset-0 bg-black/30 z-10 md:hidden" @click="toggleMenu()"></div>
    <div x-show="open" x-cloak class="fixed top-0 right-0 h-full w-3/4 sm:w-1/2 shadow-2xl z-20 bg-white dark:bg-gray-900 flex flex-col transition-all duration-300">
        <ul class="flex flex-col mt-6 space-y-5 px-6 font-medium">
            <li><a href="{{ route('blogger.dashboard') }}" @click="toggleMenu()" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Dashboard</a></li>
            <li><a href="{{ route('blogger.blogs.index') }}" @click="toggleMenu()" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">All Blogs</a></li>
            <li>
                <a href="{{ route('logout') }}" @click="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Logout</a>
                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </li>
        </ul>
    </div>
</nav>

<!-- Page Content -->
<main class="pt-24">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 py-8 text-center mt-16">
    <p>© 2025 Blogger Panel. All rights reserved.</p>
</footer>

</body>
</html>
 