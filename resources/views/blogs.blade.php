@extends('layouts.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900 py-20">
  <div class="max-w-6xl mx-auto px-4">
    <div class="text-center mb-12">
      <h1 class="text-4xl font-extrabold text-gray-800 dark:text-gray-100 mb-4">Our Latest Blogs</h1>
      <p class="text-gray-600 dark:text-gray-300">Explore insights, guides, and updates from our creative team.</p>
    </div>

    <!-- b -->
    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-8">
      @forelse ($blogs as $blog)
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl overflow-hidden hover:-translate-y-2 transition-transform duration-300">
          <img 
            src="{{ $blog->image ? asset('storage/' . $blog->image) : 'https://source.unsplash.com/600x400/?' . urlencode($blog->title) }}" 
            alt="{{ $blog->title }}" 
            class="w-full h-48 object-cover"
          >
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-100">
              {{ $blog->title }}
            </h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
              {{ Str::limit(strip_tags($blog->content), 120, '...') }}
            </p>
            <a 
              href="{{ route('blogs.show', $blog->slug) }}" 
              class="text-indigo-600 hover:underline font-medium"
            >
              Read More →
            </a>
          </div>
        </div>
      @empty
        <p class="text-gray-500 dark:text-gray-300 text-center col-span-3">
          No blogs available yet. Check back soon!
        </p>
      @endforelse
    </div>
  </div>
</section>
@endsection
