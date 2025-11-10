@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">My Blogs</h1>
    <a href="{{ route('blogger.blogs.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">+ New Blog</a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
  @endif

  @if($blogs->count())
    <div class="grid md:grid-cols-3 gap-6">
      @foreach($blogs as $blog)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
          <img src="{{ $blog->image ? asset('storage/' . $blog->image) : 'https://source.unsplash.com/600x400/?blog' }}" class="w-full h-40 object-cover" alt="{{ $blog->title }}">
          <div class="p-4">
            <h2 class="text-lg font-semibold">{{ $blog->title }}</h2>
            <p class="text-gray-600">{{ Str::limit($blog->content, 80) }}</p>
            <div class="flex justify-between mt-4">
              <a href="{{ route('blogger.blogs.edit', $blog) }}" class="text-indigo-600 hover:underline">Edit</a>
              <form action="{{ route('blogger.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Delete this blog?')">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline">Delete</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-8">
      {{ $blogs->links() }}
    </div>
  @else
    <p class="text-gray-500">No blogs yet. Create your first one!</p>
  @endif
</div>
@endsection
