@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10">

    <!-- Welcome / Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Welcome, {{ auth()->user()->name }}!</h1>
        <a href="{{ route('home') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Home</a>
    </div>

    <!-- Stats -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-indigo-600 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">Total Blogs</h2>
            <p class="text-3xl font-bold mt-2">{{ auth()->user()->blogs()->count() }}</p>
        </div>
        <div class="bg-green-600 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">Published Blogs</h2>
            <p class="text-3xl font-bold mt-2">{{ auth()->user()->blogs()->whereNotNull('published_at')->count() }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">Drafts</h2>
            <p class="text-3xl font-bold mt-2">{{ auth()->user()->blogs()->whereNull('published_at')->count() }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <a href="{{ route('blogger.blogs.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-500">+ Create New Blog</a>
    </div>

    <!-- List of Blogs -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">My Blogs</h2>
        @if(auth()->user()->blogs->count())
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach(auth()->user()->blogs as $blog)
                    <li class="py-4 flex justify-between items-center">
                        <span>{{ $blog->title }}</span>
                        <div class="flex space-x-4">
                            <a href="{{ route('blogger.blogs.edit', $blog) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('blogger.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Delete this blog?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">You haven’t created any blogs yet. Start by clicking “Create New Blog” above.</p>
        @endif
    </div>
</div>
@endsection
