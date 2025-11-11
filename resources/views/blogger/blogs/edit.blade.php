@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
  <h1 class="text-3xl font-bold mb-6">Edit Blog</h1>

  @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('blogger.blogs.update', $blog) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Title</label>
      <input type="text" name="title" value="{{ old('title', $blog->title) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Content</label>
      <textarea name="content" rows="8" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ old('content', $blog->content) }}</textarea>
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Current Image</label>
      @if ($blog->image)
        <div class="mb-2">
          <img src="{{ asset('storage/' . $blog->image) }}" alt="Current Image" class="w-full md:w-1/2 rounded shadow">
        </div>

        <label class="inline-flex items-center space-x-2 mb-2">
          <input type="checkbox" name="remove_image" value="1" class="rounded">
          <span class="text-sm text-gray-600">Remove current image</span>
        </label>
      @else
        <p class="text-sm text-gray-500 mb-2">No image uploaded.</p>
      @endif
    </div>

    <div class="mb-6">
      <label class="block text-gray-700 font-semibold mb-2">Replace Image (optional)</label>
      <input type="file" name="image" accept="image/*" class="w-full">
      <p class="text-xs text-gray-500 mt-1">Allowed: jpg, jpeg, png, webp — max 2MB</p>
    </div>

    <div class="flex space-x-3">
      <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-500">Save Changes</button>
      <a href="{{ route('blogger.blogs.index') }}" class="px-6 py-2 rounded border border-gray-300">Cancel</a>
    </div>
  </form>
</div>
@endsection
