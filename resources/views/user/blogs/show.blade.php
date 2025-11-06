@extends('user.layout')

@section('title', $blog->title)

@section('content')
<section class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-6 bg-white dark:bg-gray-800 rounded-xl shadow p-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">{{ $blog->title }}</h1>
        <p class="text-sm text-gray-500 mb-6">
            By {{ $blog->user->name ?? 'Unknown' }} • {{ $blog->created_at->diffForHumans() }}
        </p>
        <div class="prose dark:prose-invert max-w-none">
            {!! nl2br(e($blog->content)) !!}
        </div>

        <hr class="my-8 border-gray-300 dark:border-gray-700">

        <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Comments</h3>
        @foreach ($blog->comments as $comment)
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                <p class="text-gray-800 dark:text-gray-100">{{ $comment->content }}</p>
                <small class="text-gray-500">— {{ $comment->user->name ?? 'Guest' }}, {{ $comment->created_at->diffForHumans() }}</small>
            </div>
        @endforeach

        @auth
        <form action="{{ route('comments.store', $blog->id) }}" method="POST" class="mt-6">
            @csrf
            <textarea name="content" rows="3" class="w-full border rounded-lg p-3 dark:bg-gray-700 dark:text-white" placeholder="Write a comment..." required></textarea>
            <button type="submit" class="mt-3 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Post Comment</button>
        </form>
        @endauth
    </div>
</section>
@endsection
