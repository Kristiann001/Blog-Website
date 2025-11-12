@extends('user.layout')

@section('title', $blog->title)

@section('content')
<section class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-6">

        {{-- Blog Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            
            {{-- Blog Image --}}
            @if($blog->image && file_exists(public_path('storage/' . $blog->image)))
                <img src="{{ asset('storage/' . $blog->image) }}" 
                     alt="{{ $blog->title }}" 
                     class="w-full h-64 object-cover">
            @else
                <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                    <span class="text-sm">No image available</span>
                </div>
            @endif

            {{-- Blog Content --}}
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                    {{ $blog->title }}
                </h1>

                <div class="flex items-center space-x-3 mb-6 text-sm text-gray-500 dark:text-gray-400">
                    <span>By {{ $blog->user->name ?? 'Unknown Author' }}</span>
                    <span>•</span>
                    <span>{{ $blog->created_at->format('F j, Y') }}</span>
                </div>

                <div class="prose dark:prose-invert max-w-none leading-relaxed text-gray-700 dark:text-gray-300">
                    {!! nl2br(e($blog->content)) !!}
                </div>
            </div>
        </div>

        {{-- Comments Section --}}
        <div class="mt-12 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Comments</h2>

            @forelse($blog->comments as $comment)
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                    <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        — {{ $comment->user->name ?? 'Guest' }},
                        {{ $comment->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No comments yet.</p>
            @endforelse

            @auth
                <form action="{{ route('comments.store', $blog->id) }}" method="POST" class="mt-6">
                    @csrf
                    <textarea name="content" rows="3" required
                              class="w-full border border-gray-300 dark:border-gray-700 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-gray-50 dark:bg-gray-900 dark:text-gray-100"
                              placeholder="Add a comment..."></textarea>
                    <button type="submit"
                            class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition">
                        Post Comment
                    </button>
                </form>
            @else
                <p class="mt-6 text-gray-500 dark:text-gray-400">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">Login</a> to post a comment.
                </p>
            @endauth
        </div>

        {{-- Back to Blogs --}}
        <div class="mt-8 text-center">
            <a href="{{ route('publicblog.index') }}" 
               class="inline-block text-indigo-600 hover:text-indigo-700 font-medium">
                ← Back to Blogs
            </a>
        </div>
    </div>
</section>
@endsection
