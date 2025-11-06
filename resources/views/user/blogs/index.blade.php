<!-- @extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-50 dark:bg-gray-900">
  <div class="max-w-6xl mx-auto px-6">

    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">My Blogs</h1>
      <a href="{{ route('user.blogs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl shadow">
        + New Blog
      </a>
    </div>

    @if(session('success'))
      <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

    @if($blogs->count())
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($blogs as $blog)
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $blog->title }}</h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ Str::limit($blog->content, 100) }}</p>

            <div class="flex justify-between">
              <a href="{{ route('blogs.show', $blog->slug) }}" class="text-blue-500 hover:underline">View</a>
              <div class="flex gap-3">
                <a href="{{ route('user.blogs.edit', $blog) }}" class="text-yellow-500 hover:underline">Edit</a>
                <form action="{{ route('user.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Delete this blog?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="text-red-500 hover:underline">Delete</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-8">{{ $blogs->links() }}</div>
    @else
      <p class="text-gray-500">You haven’t created any blogs yet.</p>
    @endif
  </div>
</section>
@endsection -->
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
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 hover:shadow-lg transition">
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
                            <a href="{{ route('blogs.show', $blog->slug) }}" 
                               class="text-indigo-600 hover:text-indigo-700 font-medium">
                                Read More →
                            </a>
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
