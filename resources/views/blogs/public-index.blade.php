@extends('user.layout')

@section('title', 'Explore Blogs')

@section('content')
<section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Explore Blogs</h1>
        </div>

        @if($blogs->count())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($blogs as $blog)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 hover:shadow-xl transition transform hover:-translate-y-1 duration-200">
                        {{-- Blog Title --}}
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                            {{ $blog->title }}
                        </h2>

                        {{-- Blog Excerpt --}}
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                            {{ Str::limit(strip_tags($blog->content), 120) }}
                        </p>

                        {{-- Blog Meta & Link --}}
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">
                                By {{ $blog->user->name ?? 'Unknown' }}
                            </span>
                            <a href="{{ route('publicblog.show', $blog->slug) }}" 
                               class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium transition">
                                Read More →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $blogs->links('pagination::tailwind') }}
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 text-center mt-12">No blogs found yet.</p>
        @endif
    </div>
</section>
@endsection
