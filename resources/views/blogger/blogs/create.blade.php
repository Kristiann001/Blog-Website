@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
  <h1 class="text-3xl font-bold mb-6">Create New Blog</h1>

  <form method="POST" action="{{ route('blogger.blogs.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Title</label>
      <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Content</label>
      <textarea name="content" rows="6" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ old('content') }}</textarea>
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Image</label>
      <input type="file" name="image" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm">
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-500">Publish</button>
  </form>
</div>
@endsection
