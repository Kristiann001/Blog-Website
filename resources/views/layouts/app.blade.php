<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Zenith Stories'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --accent: #06b6d4;
                --accent-hover: #0891b2;
            }
            body { font-family: 'Inter', system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
            .brand-font { font-family: 'Cormorant Garamond', Georgia, serif; }

            /* Glass */
            .glass { background: rgba(255,255,255,0.75); backdrop-filter: blur(16px) saturate(180%); -webkit-backdrop-filter: blur(16px) saturate(180%); border: 1px solid rgba(255,255,255,0.3); }

            /* Hero gradient */
            .hero-gradient { background: linear-gradient(180deg, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0.55) 100%); }

            /* Card overlay */
            .card-overlay { background: linear-gradient(180deg, rgba(0,0,0,0) 20%, rgba(0,0,0,0.5) 100%); transition: all 0.5s ease; }
            .group:hover .card-overlay { background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.65) 100%); }

            /* Smooth image zoom on card hover */
            .card-zoom img { transition: transform 0.7s cubic-bezier(0.16,1,0.3,1); }
            .card-zoom:hover img { transform: scale(1.08); }

            /* Subtle entry animation */
            @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
            .animate-fade-up { animation: fadeUp 0.6s ease-out both; }

            /* First letter styling for articles */
            .article-body > p:first-of-type::first-letter {
                float: left;
                font-family: 'Cormorant Garamond', serif;
                font-size: 4rem;
                line-height: 0.8;
                padding: 0.1em 0.12em 0 0;
                color: #111;
                font-weight: 700;
            }
        </style>
    </head>
    <body class="antialiased text-gray-800 bg-[#fafafa]">
        <div class="min-h-screen flex flex-col">
            @include('partials.blog-navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white border-b border-gray-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
        @yield('scripts')
    </body>
</html>
