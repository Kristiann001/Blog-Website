<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $post->title }} - BLOG</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .brand-font { font-family: 'Cormorant Garamond', serif; }
            .glass-dark { background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); }
            .premium-text { background: linear-gradient(to right, #22d3ee, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 text-center sticky top-16 z-50">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-4 text-center sticky top-16 z-50">
                {{ session('error') }}
            </div>
        @endif

        <!-- Unified Navbar -->
        @include('partials.blog-navigation')

        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <article class="bg-white shadow-sm border border-gray-100 overflow-hidden">
                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" class="w-full h-[300px] md:h-[500px] object-cover">
                @endif

                <div class="p-6 md:p-12 text-center">
                    <span class="text-cyan-500 text-[10px] md:text-xs font-bold tracking-widest uppercase">{{ $post->category->name ?? 'General' }}</span>
                    <h1 class="text-2xl md:text-4xl font-bold uppercase mt-4 md:mt-6 mb-4 tracking-tight leading-tight">{{ $post->title }}</h1>
                    
                    <div class="flex flex-wrap items-center justify-center space-x-2 text-[9px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-8 md:mb-12">
                        <span>By: <span class="text-gray-900">{{ $post->user->name }}</span></span>
                        <span>•</span>
                        <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</span>
                        @if($post->price > 0)
                            <span class="hidden md:inline">•</span>
                            <span class="w-full md:w-auto mt-2 md:mt-0 text-cyan-500">Ksh {{ number_format($post->price) }}</span>
                        @endif
                    </div>

                    <div class="prose max-w-none text-gray-700 leading-loose text-left mb-12">
                        @php
                            $isPremium = $post->price > 0;
                            $hasPurchased = auth()->check() && auth()->user()->hasPurchased($post);
                            $isAdmin = auth()->check() && auth()->user()->role === 'admin';
                        @endphp

                        @if(!$isPremium || $hasPurchased || $isAdmin)
                            {!! nl2br(e($post->content)) !!}
                        @else
                            <div class="relative">
                                <div class="text-gray-400 select-none blur-sm">
                                    {!! nl2br(e(Str::limit($post->content, 300))) !!}
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="glass-dark p-8 shadow-2xl text-center max-w-sm rounded-2xl border border-white/10">
                                        <h3 class="text-2xl font-bold uppercase mb-4 premium-text">Premium Content</h3>
                                        <p class="text-sm text-gray-300 mb-6 leading-relaxed">This exclusive story requires a one-time purchase to unlock full lifetime access.</p>
                                        
                                        @auth
                                            @if(auth()->user()->role === 'admin')
                                                <div class="mt-8 p-6 glass-dark rounded-xl border border-white/10 text-center">
                                                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-cyan-400">Admin Preview Mode</p>
                                                    <p class="text-[9px] text-gray-400 mt-2 uppercase tracking-widest">You have full access to this content as an administrator.</p>
                                                </div>
                                            @else
                                                <form action="{{ route('payment.initiate', $post) }}" method="POST" class="mt-8">
                                                    @csrf
                                                    <div class="mb-6">
                                                        <input type="text" name="phone_number" placeholder="2547XXXXXXXX" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white text-sm focus:outline-none focus:border-cyan-400 transition placeholder:text-gray-600 text-center" required>
                                                        <p class="text-[9px] text-gray-500 mt-3 uppercase tracking-widest">Enter M-Pesa number in 254... format</p>
                                                    </div>
                                                    <button type="submit" class="w-full bg-cyan-500 text-white font-bold py-4 rounded-xl text-[10px] uppercase tracking-[0.4em] hover:bg-white hover:text-cyan-500 transition-all shadow-2xl">
                                                        Unlock Story &bull; Ksh {{ number_format($post->price) }}
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="inline-block mt-8 bg-white text-gray-900 font-bold px-12 py-4 rounded-xl text-[10px] uppercase tracking-[0.4em] hover:bg-cyan-500 hover:text-white transition-all shadow-2xl">
                                                Login to Purchase
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-16 border-t border-gray-100 pt-16 text-center">
                        <a href="{{ route('blog.index') }}" class="text-[10px] font-bold uppercase tracking-[0.4em] text-cyan-500 hover:text-gray-900 transition">
                            &larr; Discover more stories
                        </a>
                    </div>
                </div>
            </article>
        </main>

        <footer class="py-16 text-center text-gray-400 text-[10px] font-bold tracking-[0.3em] uppercase">
            &copy; {{ date('Y') }} Blog Theme. Crafted for Creatives.
        </footer>

        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    </body>
</html>
