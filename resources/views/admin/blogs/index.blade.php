@extends('admin.layout')

@section('title', 'Manage Blogs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">All Blogs</h2>
    <a href="{{ route('admin.blogs.create') }}" 
       class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg shadow">
        + New Blog
    </a>
</div>

@if (session('success'))
    <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow">
    <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">Title</th>
                <th class="px-6 py-3">Author</th>
                <th class="px-6 py-3">Created</th>
                <th class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($blogs as $blog)
                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">{{ $blog->title }}</td>
                    <td class="px-6 py-3">{{ $blog->user->name ?? 'Unknown' }}</td>
                    <td class="px-6 py-3">{{ $blog->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-3 text-right flex justify-end gap-3">
                        <a href="{{ route('publicblog.show', $blog->slug) }}" 
                           class="text-blue-500 hover:underline">View</a>
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" 
                           class="text-yellow-500 hover:underline">Edit</a>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this blog?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">No blogs found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $blogs->links() }}
</div>
@endsection