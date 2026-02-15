@extends('layouts.app')

@section('title', 'Zenith Stories — Premium Editorial')

@section('content')

{{-- Hero --}}
<section class="relative h-[60vh] md:h-[72vh] flex items-center justify-center text-center overflow-hidden">
    <img src="https://images.unsplash.com/photo-1432821596592-e2c18b78144f?auto=format&fit=crop&w=1920&q=80"
         alt="Hero background"
         class="absolute inset-0 w-full h-full object-cover scale-105">
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="relative z-10 px-6 animate-fade-up">
        <h1 class="brand-font text-6xl sm:text-7xl md:text-8xl lg:text-9xl text-white font-bold tracking-tight leading-none">
            Zenith
        </h1>
        <div class="mt-5 md:mt-6 flex flex-col items-center">
            <div class="w-12 h-px bg-cyan-400/70 mb-4"></div>
            <p class="text-white/80 text-xs sm:text-sm font-medium tracking-[0.25em] uppercase">Premium Editorial Stories</p>
        </div>
    </div>
</section>

{{-- Category Feature Cards --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 md:-mt-20 relative z-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 md:gap-6">
        @php
            $catVisuals = [
                ['label' => 'Epicurean',  'title' => 'The Art of Slow Living',          'img' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=80'],
                ['label' => 'Monologue',  'title' => 'Rituals of the Modern Nomad',     'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80'],
                ['label' => 'Odyssey',    'title' => 'Journeys Beyond the Horizon',     'img' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80'],
            ];
        @endphp
        @foreach($catVisuals as $i => $cv)
        <div class="group card-zoom relative aspect-[4/5] sm:aspect-[3/4] overflow-hidden rounded-2xl shadow-lg cursor-pointer animate-fade-up"
             style="animation-delay: {{ $i * 0.1 }}s">
            <img src="{{ $cv['img'] }}" alt="{{ $cv['title'] }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 card-overlay"></div>
            <div class="absolute inset-x-0 bottom-0 p-6 md:p-7">
                <span class="text-[10px] font-bold tracking-[0.3em] uppercase text-cyan-300 block mb-1.5">{{ $cv['label'] }}</span>
                <h3 class="brand-font text-xl md:text-2xl font-bold text-white leading-snug">{{ $cv['title'] }}</h3>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Main content --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
    <div class="flex flex-col lg:flex-row gap-10 lg:gap-14">

        {{-- Posts --}}
        <div class="lg:w-2/3 space-y-10">
            @forelse($posts as $index => $post)
            <article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100/80 transition-shadow duration-300 animate-fade-up"
                     style="animation-delay: {{ $index * 0.05 }}s">

                {{-- Image --}}
                @if($post->featured_image)
                <a href="{{ route('blog.show', $post->slug) }}" class="block relative h-64 sm:h-72 md:h-80 overflow-hidden card-zoom">
                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                @else
                <a href="{{ route('blog.show', $post->slug) }}" class="block relative h-64 sm:h-72 md:h-80 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center">
                    <i class="fas fa-feather-alt text-3xl text-gray-200"></i>
                </a>
                @endif

                {{-- Content --}}
                <div class="p-6 md:p-8">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-600 bg-cyan-50 px-2.5 py-1 rounded-md">
                            {{ $post->category->name ?? 'General' }}
                        </span>
                        @if($post->price > 0)
                            <span class="text-[10px] font-bold tracking-wider uppercase text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md">
                                <i class="fas fa-lock text-[8px] mr-1"></i> Ksh {{ number_format($post->price) }}
                            </span>
                        @endif
                    </div>

                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-snug mb-3">
                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-cyan-600 transition-colors duration-200">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-3">
                        {{ Str::limit(strip_tags($post->content), 180) }}
                    </p>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2 text-xs text-gray-400">
                            <span class="font-medium text-gray-600">{{ $post->user->name }}</span>
                            <span>&middot;</span>
                            <time>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</time>
                        </div>
                        <a href="{{ route('blog.show', $post->slug) }}"
                           class="text-xs font-semibold text-cyan-600 hover:text-cyan-700 transition-colors inline-flex items-center group/link">
                            Read
                            <svg class="w-3.5 h-3.5 ml-1 transition-transform group-hover/link:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <i class="fas fa-pen-nib text-3xl text-gray-200 mb-4"></i>
                <p class="text-gray-400 text-sm">Stories are on the way. Check back soon.</p>
            </div>
            @endforelse

            {{-- Pagination --}}
            <div class="pt-4 flex justify-center">
                {{ $posts->links() }}
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="lg:w-1/3 space-y-6">
            {{-- Categories --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-bold text-gray-900 mb-4">Categories</h4>
                <div class="space-y-1">
                    @foreach($categories as $category)
                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                           class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm {{ request('category') == $category->slug ? 'bg-cyan-50 text-cyan-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                            <span>{{ $category->name }}</span>
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <span class="brand-font text-2xl font-bold text-gray-900">Zenith<span class="text-cyan-500">.</span></span>
                <p class="text-xs text-gray-400 mt-1">&copy; {{ date('Y') }} Zenith Stories. All rights reserved.</p>
            </div>
            <a href="{{ route('help') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-cyan-600 transition-colors">
                <i class="fas fa-question-circle mr-1.5"></i> Help
            </a>
        </div>
    </div>
</footer>

@endsection
