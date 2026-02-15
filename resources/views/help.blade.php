@extends('layouts.app')

@section('title', 'Help — Zenith Stories')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">

    {{-- Page header --}}
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Help Center</h1>
        <p class="text-gray-500 text-sm">Everything you need to navigate Zenith Stories.</p>
    </div>

    <div class="space-y-8">

        {{-- Customer Section --}}
        <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-cyan-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user text-cyan-600 text-sm"></i>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">For Readers</h2>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">1</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Browse Stories</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Visit the <a href="{{ route('blog.index') }}" class="text-cyan-600 hover:underline">homepage</a> to see all stories. Use the navbar categories (Technology, Lifestyle, Travel) to filter by topic.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">2</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Read a Story</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Click any story title or the <strong>"Read"</strong> link to open the full article. Free stories are available immediately.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">3</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Unlock Premium Stories</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Some stories require a one-time payment. Sign in, enter your M-Pesa phone number (format: <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs font-mono">254XXXXXXXXX</code>), and tap <strong>"Unlock"</strong>. You'll receive an STK push on your phone.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">4</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Your Dashboard</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">After signing in, click <strong>"Dashboard"</strong> in the navbar to see your purchased stories and account details.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">5</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Go Back</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Use the <strong>"← Back to all stories"</strong> link at the bottom of any article, or click <strong>"Home"</strong> in the navbar to return to the homepage.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Admin Section --}}
        <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-shield-alt text-amber-600 text-sm"></i>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">For Admins</h2>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">1</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Admin Dashboard</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Sign in with your admin account and click <strong>"Dashboard"</strong> in the navbar. The admin dashboard shows stats, recent posts, and quick actions.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">2</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Create a Post</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">From the dashboard, click <strong>"Create New Post"</strong>. Fill in the title, content, category, featured image, and optionally set a price for premium content. Hit <strong>"Publish"</strong> to make it live.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">3</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Edit or Delete Posts</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">In the dashboard post list, use the <strong>"Edit"</strong> button to modify a story or <strong>"Delete"</strong> to remove it. Changes take effect immediately.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">4</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Premium Content</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Set a price (in Ksh) when creating or editing a post to make it premium. Readers will need to pay via M-Pesa to access the full content. As an admin, you can view all content without paying.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-gray-500">5</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">View the Blog</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Click <strong>"Home"</strong> in the navbar or the <strong>"Zenith."</strong> logo to see the public blog exactly as readers see it.</p>
                    </div>
                </div>
            </div>
        </section>

    </div>

    {{-- Back link --}}
    <div class="mt-10">
        <a href="{{ route('blog.index') }}"
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-cyan-600 transition-colors group">
            <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Back to stories
        </a>
    </div>
</div>

@endsection
