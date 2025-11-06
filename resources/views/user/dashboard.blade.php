@extends('user.layout')

@section('title', 'User Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow hover:-translate-y-1 transition-transform duration-300">
        <h2 class="text-lg font-semibold mb-2 text-gray-700 dark:text-gray-200">My Comments</h2>
        <p class="text-3xl font-bold text-indigo-600">{{ $myComments }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow hover:-translate-y-1 transition-transform duration-300">
        <h2 class="text-lg font-semibold mb-2 text-gray-700 dark:text-gray-200">Blogs Read</h2>
        <p class="text-3xl font-bold text-indigo-600">{{ $blogsRead ?? 0 }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow hover:-translate-y-1 transition-transform duration-300">
        <h2 class="text-lg font-semibold mb-2 text-gray-700 dark:text-gray-200">Member Since</h2>
        <p class="text-3xl font-bold text-indigo-600">
            {{ Auth::user()->created_at->format('M Y') }}
        </p>
    </div>
</div>

<div class="mt-8 bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
    <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200">Explore</h3>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('blogs') }}" 
           class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-md transition">Browse Blogs</a>

        <a href="{{ route('profile.edit') }}" 
           class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
           Edit Profile
        </a>
    </div>
</div>
@endsection
