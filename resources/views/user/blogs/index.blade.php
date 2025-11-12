@extends('user.layout')

@section('title', 'Explore Blogs')

@section('content')
<section class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Explore Blogs</h1>
        </div>

        @if($blogs->count())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($blogs as $blog)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden hover:shadow-lg transition">

                        {{-- Blog Image --}}
                        @if($blog->image && file_exists(public_path('storage/' . $blog->image)))
                            <img src="{{ asset('storage/' . $blog->image) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                                <span class="text-sm">No image available</span>
                            </div>
                        @endif

                        {{-- Blog Details --}}
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                                {{ $blog->title }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                {{ Str::limit($blog->content, 120) }}
                            </p>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 dark:text-gray-400">
                                    By {{ $blog->user->name ?? 'Unknown' }}
                                </span>
                                <a href="{{ route('publicblog.show', $blog->slug) }}" 
                                   class="text-indigo-600 hover:text-indigo-700 font-medium">
                                    Read More →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $blogs->links() }}
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No blogs found yet.</p>
        @endif
    </div>
</section>
@endsection
