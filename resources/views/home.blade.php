@extends('layouts.app')

@section('title', 'Home - MyBlogsite')

@section('content')
<section class="pb-20 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-center">
    <div class="max-w-3xl mx-auto py-20">
        <h2 class="text-5xl font-bold mb-4">Welcome to MyBlogsite!</h2>
        <p class="text-lg mb-6">Discover inspiring stories, tech tutorials, and lifestyle articles curated for you.</p>
        <a href="{{route('publicblog.index')}}" class="bg-white text-indigo-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-200">Explore Blogs</a>
    </div>
</section>

<section id="blogs" class="py-16 max-w-6xl mx-auto px-6">
    <h3 class="text-3xl font-bold text-center mb-12 text-gray-800">Featured Posts</h3>

    @if ($latestBlogs->count() > 0)
        <div class="grid md:grid-cols-3 gap-8">
            @foreach ($latestBlogs as $blog)
                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition">
                    <img 
                        src="{{ $blog->image ? asset('storage/' . $blog->image) : 'https://source.unsplash.com/600x400/?blog,writing' }}" 
                        class="rounded-t-2xl w-full h-56 object-cover" 
                        alt="{{ $blog->title }}"
                    >
                    <div class="p-6">
                        <h4 class="text-xl font-semibold mb-2 text-indigo-600">{{ $blog->title }}</h4>
                        <p class="text-gray-600 mb-4">
                            {{ Str::limit(strip_tags($blog->content), 100) }}
                        </p>
                        <a href="{{ route('publicblog.index') }}" class="text-indigo-600 font-medium hover:underline">
                            Read More →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-600">No blogs available yet. Check back soon!</p>
    @endif
</section>
@endsection
