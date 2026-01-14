@extends('layouts.app')

@section('title', $blog->title . ' - Nexus Insight')

@section('content')
<article class="bg-white dark:bg-gray-950 min-h-screen">
    {{-- Cinematic Hero Header --}}
    <header class="relative w-full h-[60vh] md:h-[70vh] flex items-center justify-center overflow-hidden">
        <img 
            src="{{ $blog->image && file_exists(public_path('storage/' . $blog->image)) ? asset('storage/' . $blog->image) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=1600&auto=format&fit=crop' }}" 
            alt="{{ $blog->title }}" 
            class="absolute inset-0 w-full h-full object-cover"
        >
        <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
            <div class="inline-flex items-center space-x-2 text-indigo-400 font-bold uppercase tracking-widest text-sm mb-6">
                <span>{{ $blog->created_at->format('M d, Y') }}</span>
                <span class="text-gray-500">•</span>
                <span>{{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black tracking-tight text-white mb-8 leading-tight">
                {{ $blog->title }}
            </h1>
            <div class="flex items-center justify-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-lg shadow-xl shadow-indigo-500/20">
                    {{ substr($blog->user->name ?? 'U', 0, 1) }}
                </div>
                <div class="text-left text-white">
                    <p class="font-bold border-b border-indigo-500/50 pb-0.5">{{ $blog->user->name ?? 'Unknown Author' }}</p>
                    <p class="text-sm text-gray-400">Thought Leader</p>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto px-6 py-20">
        {{-- Main Content --}}
        <div class="prose prose-xl prose-indigo dark:prose-invert max-w-none leading-relaxed text-gray-700 dark:text-gray-300">
            {!! nl2br(e($blog->content)) !!}
        </div>

        {{-- Signature / Bottom Meta --}}
        <div class="mt-20 pt-10 border-t border-gray-100 dark:border-gray-800 flex flex-col md:flex-row md:items-center md:justify-between space-y-6 md:space-y-0">
            <div class="flex items-center space-x-4">
                <span class="text-gray-400 font-medium">Share this insight</span>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-indigo-600 transition">Twitter</a>
                    <a href="#" class="text-gray-400 hover:text-indigo-600 transition">LinkedIn</a>
                </div>
            </div>
            <a href="{{ route('publicblog.index') }}" class="inline-flex items-center font-bold text-indigo-600 hover:text-indigo-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Return to Library
            </a>
        </div>

        {{-- Glassmorphic Comments Section --}}
        <section class="mt-32 pb-20">
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 p-8 md:p-12 shadow-sm">
                <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white mb-10 flex items-center">
                    Dialogue
                    <span class="ml-4 px-3 py-1 bg-indigo-600 text-white text-xs rounded-full font-bold uppercase tracking-wider">
                        {{ $blog->comments->count() }}
                    </span>
                </h2>

                <div class="space-y-10">
                    @forelse($blog->comments as $comment)
                        <div class="flex space-x-4 group">
                            <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-sm font-bold text-gray-500">
                                {{ substr($comment->user->name ?? 'G', 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $comment->user->name ?? 'Guest Reader' }}</span>
                                    <span class="text-gray-400 text-xs">•</span>
                                    <span class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 opacity-40">
                            <p class="text-gray-500 italic">Be the first to start the conversation.</p>
                        </div>
                    @endforelse
                </div>

                @auth
                    <div class="mt-16 pt-10 border-t border-gray-100 dark:border-gray-800">
                        <form action="{{ route('comments.store', $blog->id) }}" method="POST">
                            @csrf
                            <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Your Perspective</label>
                            <textarea name="content" rows="4" required
                                      class="w-full border-2 border-gray-100 dark:border-gray-800 rounded-3xl p-6 focus:outline-none focus:border-indigo-500 bg-white dark:bg-gray-950 dark:text-gray-100 transition-colors duration-300"
                                      placeholder="Share your thoughts..."></textarea>
                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                        class="px-10 py-4 bg-gray-900 dark:bg-indigo-600 text-white rounded-2xl font-bold shadow-xl hover:bg-gray-800 dark:hover:bg-indigo-700 hover:-translate-y-1 transition duration-300">
                                    Publish Perspective
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="mt-16 text-center py-10 bg-white/50 dark:bg-black/20 rounded-3xl border border-gray-100 dark:border-gray-800">
                        <p class="text-gray-600 dark:text-gray-400 font-medium">
                            Ready to contribute? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-bold mx-1">Login</a> to join the dialogue.
                        </p>
                    </div>
                @endauth
            </div>
        </section>
    </div>
</article>
@endsection
