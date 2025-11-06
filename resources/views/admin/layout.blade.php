<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-indigo-700 text-white flex flex-col">
            <div class="p-4 text-2xl font-bold border-b border-indigo-500">
                Admin Panel
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-indigo-600 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600' : '' }}">
                    Home
                </a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-indigo-600">Manage Blogs</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-indigo-600">Users</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-indigo-600">Settings</a>
            </nav>

            <div class="p-4 border-t border-indigo-500">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full bg-indigo-600 py-2 rounded hover:bg-indigo-500">Logout</button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="flex-1 p-6">
            {{-- Topbar --}}
            <header class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">@yield('title')</h1>
                <div>Welcome, <span class="font-semibold">{{ Auth::user()->name }}</span></div>
            </header>

            {{-- Page Content --}}
            <div>
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
