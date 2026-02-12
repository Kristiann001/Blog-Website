<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BLOG - A Perfect Theme</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .brand-font { font-family: 'Cormorant Garamond', serif; }
            .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); }
            .card-overlay { background: rgba(0,0,0,0.25); transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
            .card-overlay:hover { background: rgba(0,0,0,0.45); backdrop-filter: blur(4px); }
            .category-card:hover img { transform: scale(1.1); }
            .hero-gradient { background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.5)); }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased">
        <!-- Unified Navbar -->
        @include('partials.blog-navigation')

        <!-- Huge Header Section -->
        <header class="relative h-[60vh] md:h-[80vh] flex flex-col items-center justify-center text-center overflow-hidden">
            <img src="https://images.unsplash.com/photo-1432821596592-e2c18b78144f?auto=format&fit=crop&w=1920&q=80" class="absolute inset-0 w-full h-full object-cover scale-105 transition-transform duration-[10s] hover:scale-100">
            <div class="absolute inset-0 hero-gradient"></div>
            <div class="relative z-10 px-4">
                <h1 class="brand-font text-6xl md:text-9xl text-white font-bold tracking-tighter drop-shadow-2xl">Zenith</h1>
                <p class="uppercase text-white tracking-[0.5em] md:tracking-[1em] font-medium mt-4 md:mt-6 text-[8px] md:text-[10px] pl-2 md:pl-4 opacity-70">Premium Editorial Stories</p>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 md:-mt-20 relative z-20">
            <!-- Featured Category Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                @php 
                    $catVisuals = [
                        ['name' => 'FOOD', 'label' => 'Epicurean', 'title' => 'The Art of Slow Living', 'img' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=80'],
                        ['name' => 'LIFESTYLE', 'label' => 'Monologue', 'title' => 'Rituals of the Modern Nomad', 'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80'],
                        ['name' => 'TRAVEL', 'label' => 'Odyssey', 'title' => 'Journeys Beyond the Horizon', 'img' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80']
                    ];
                @endphp
                @foreach($catVisuals as $cv)
                <div class="relative aspect-[4/5] overflow-hidden rounded-2xl category-card shadow-2xl group cursor-pointer">
                    <img src="{{ $cv['img'] }}" class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                    <div class="absolute inset-0 card-overlay flex items-center justify-center p-8">
                        <div class="bg-white/95 px-8 py-6 text-center rounded-sm transform transition-transform duration-500 group-hover:scale-105">
                            <h4 class="text-[9px] font-bold tracking-[0.4em] uppercase text-cyan-600 mb-1">{{ $cv['label'] }}</h4>
                            <h3 class="brand-font text-xl font-bold text-gray-900 leading-tight">{{ $cv['title'] }}</h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Posts Grid -->
                <div class="lg:w-2/3 space-y-12">
                    @foreach($posts as $post)
                    <article class="bg-white shadow-sm border border-gray-100 overflow-hidden">
                        @if($post->featured_image)
                        <div class="relative h-80 overflow-hidden">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4 bg-cyan-400 text-white p-2">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        @endif
                        <div class="p-8 text-center">
                            <span class="text-cyan-500 text-xs font-bold tracking-widest uppercase">{{ $post->category->name ?? 'General' }}</span>
                            <h2 class="text-2xl font-bold uppercase mt-4 mb-2 tracking-tight">
                                <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-cyan-500 transition">{{ $post->title }}</a>
                            </h2>
                            <div class="flex items-center justify-center space-x-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">
                                <span>By: <span class="text-gray-900">{{ $post->user->name }}</span></span>
                                <span>•</span>
                                <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</span>
                                @if($post->price > 0)
                                <span>•</span>
                                <span class="text-cyan-500">Ksh {{ number_format($post->price) }}</span>
                                @endif
                            </div>
                            <p class="text-gray-500 text-sm leading-relaxed mb-8">
                                {{ Str::limit(strip_tags($post->content), 200) }}
                            </p>
                            <div class="flex flex-col items-center">
                                <a href="{{ route('blog.show', $post->slug) }}" class="border border-gray-200 px-8 py-3 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-gray-900 hover:text-white transition rounded-full">Explore Story</a>
                            </div>
                        </div>
                    </article>
                    @endforeach

                    <div class="py-8">
                        {{ $posts->links() }}
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="lg:w-1/3 space-y-12">
                    <div class="glass p-8 border border-gray-100 text-center shadow-sm rounded-xl">
                        <h4 class="text-xs font-bold tracking-widest uppercase border-b border-gray-100 pb-4 mb-8">About Me</h4>
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=150&h=150&q=80" class="w-24 h-24 rounded-full mx-auto mb-6 object-cover shadow-lg border-2 border-white">
                        <p class="text-gray-500 text-xs leading-loose italic">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore.
                        </p>
                    </div>

                    <div class="glass p-8 border border-gray-100 text-center shadow-sm rounded-xl">
                        <h4 class="text-xs font-bold tracking-widest uppercase border-b border-gray-100 pb-4 mb-8">Premium Stories</h4>
                        <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest leading-relaxed">
                            Support our writers by purchasing exclusive content.
                        </p>
                    </div>
                </aside>
            </div>
        </main>

        <footer class="bg-gray-900 border-t border-white/5 py-24">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="brand-font text-6xl text-white font-bold tracking-tighter mb-6">Zenith</h1>
                <p class="text-gray-500 text-[9px] font-bold tracking-[0.4em] uppercase mb-16">&copy; {{ date('Y') }} Zenith Stories. An Evolution in Editorial Design.</p>
                <div class="flex justify-center space-x-12 text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400">
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Get in Touch</a>
                </div>
            </div>
        </footer>

        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    </body>
</html>
