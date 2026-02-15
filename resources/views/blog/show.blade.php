@extends('layouts.app')

@section('title', $post->title . ' — Zenith Stories')

@section('content')

<article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16 animate-fade-up">

    {{-- Flash messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-600 hover:text-green-800"><i class="fas fa-times"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-red-600 hover:text-red-800"><i class="fas fa-times"></i></button>
        </div>
    @endif

    {{-- Featured Image --}}
    @if($post->featured_image)
        <div class="relative rounded-2xl overflow-hidden mb-8 shadow-lg card-zoom">
            <img src="{{ asset('storage/' . $post->featured_image) }}"
                 alt="{{ $post->title }}"
                 class="w-full h-auto max-h-[500px] object-cover">
        </div>
    @endif

    {{-- Header --}}
    <header class="mb-8">
        <div class="flex items-center space-x-3 mb-4">
            <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-600 bg-cyan-50 px-2.5 py-1 rounded-md">
                {{ $post->category->name ?? 'General' }}
            </span>
            @if($post->price > 0)
                <span class="text-[10px] font-bold tracking-wider uppercase text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md">
                    <i class="fas fa-lock text-[8px] mr-1"></i> Premium · Ksh {{ number_format($post->price) }}
                </span>
            @endif
        </div>

        <h1 class="text-3xl sm:text-4xl md:text-[2.75rem] font-extrabold text-gray-900 leading-tight tracking-tight mb-5">
            {{ $post->title }}
        </h1>

        <div class="flex items-center space-x-3 text-sm text-gray-500">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fas fa-user text-xs text-gray-400"></i>
            </div>
            <div>
                <span class="font-semibold text-gray-800">{{ $post->user->name }}</span>
                <span class="mx-1.5 text-gray-300">&middot;</span>
                <time>{{ $post->published_at ? $post->published_at->format('F d, Y') : 'Draft' }}</time>
            </div>
        </div>
    </header>

    <hr class="border-gray-100 mb-8">

    {{-- Body --}}
    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
        @php
            $isPremium = $post->price > 0;
            $hasPurchased = auth()->check() && auth()->user()->hasPurchased($post);
            $isAdmin = auth()->check() && auth()->user()->role === 'admin';
        @endphp

        @if(!$isPremium || $hasPurchased || $isAdmin)
            <div class="article-body space-y-5">
                {!! nl2br(e($post->content)) !!}
            </div>
        @else
            {{-- Locked content --}}
            <div class="relative">
                <div class="text-gray-300 blur-[6px] select-none pointer-events-none leading-relaxed">
                    {!! nl2br(e(Str::limit($post->content, 400))) !!}
                </div>

                <div class="absolute inset-0 flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-8 md:p-10 max-w-sm w-full text-center">
                        <div class="w-14 h-14 bg-gray-900 rounded-2xl flex items-center justify-center mx-auto mb-5 rotate-3">
                            <i class="fas fa-lock text-cyan-400 text-lg"></i>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-2">Premium Story</h3>
                        <p class="text-sm text-gray-500 mb-6 leading-relaxed">Support our editorial team with a one-time contribution to unlock this story.</p>

                        @auth
                            @if(auth()->user()->role === 'admin')
                                <div class="bg-cyan-50 border border-cyan-100 rounded-xl p-4">
                                    <p class="text-xs font-bold text-cyan-700 uppercase tracking-wider">Admin access granted</p>
                                </div>
                            @else
                                <form action="{{ route('payment.initiate', $post) }}" method="POST"
                                      x-data="{ loading: false }" @submit="loading = true">
                                    @csrf
                                    <div class="mb-4">
                                        <input type="text" name="phone_number"
                                               placeholder="254712345678"
                                               pattern="254[0-9]{9}" maxlength="12"
                                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-center text-sm font-mono tracking-wider focus:outline-none focus:ring-2 focus:ring-cyan-500/30 focus:border-cyan-500 transition placeholder:text-gray-300"
                                               required x-bind:disabled="loading">
                                        <p class="text-[10px] text-gray-400 mt-2">M-Pesa format: 254XXXXXXXXX</p>
                                    </div>
                                    <button type="submit" x-bind:disabled="loading"
                                            class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl text-sm hover:bg-cyan-600 transition-colors disabled:opacity-50">
                                        <span x-show="!loading">Unlock · Ksh {{ number_format($post->price) }}</span>
                                        <span x-show="loading" x-cloak class="inline-flex items-center space-x-2">
                                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Processing…</span>
                                        </span>
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-block w-full bg-gray-900 text-white font-bold py-3 rounded-xl text-sm hover:bg-cyan-600 transition-colors">
                                Sign in to Unlock
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Back link --}}
    <div class="mt-12 pt-8 border-t border-gray-100">
        <a href="{{ route('blog.index') }}"
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-cyan-600 transition-colors group">
            <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Back to all stories
        </a>
    </div>
</article>

@endsection
