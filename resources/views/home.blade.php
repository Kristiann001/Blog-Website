@extends('layouts.app')

@section('title', 'Home - Nexus Insight')

@section('content')
<section class="relative overflow-hidden pt-16 pb-32 lg:pt-24 lg:pb-48">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
    </div>
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-5xl md:text-7xl font-black tracking-tight mb-8 bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-400">
            NexusInsight
        </h2>
        <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 leading-relaxed mb-10">
            Exploring the intersection of technology, culture, and innovation. 
            Join our community of forward-thinking readers.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{route('publicblog.index')}}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 hover:-translate-y-1 transition duration-300">
                Browse Articles
            </a>
            <a href="{{route('about')}}" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-100 dark:border-gray-700 rounded-2xl font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300">
                Our Mission
            </a>
        </div>
    </div>
</section>

<section id="blogs" class="py-24 max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
        <div class="max-w-lg">
            <h3 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white mb-4">Featured Insights</h3>
            <p class="text-gray-500 dark:text-gray-400">Curated articles from our expert contributors and researchers.</p>
        </div>
        <a href="{{ route('publicblog.index') }}" class="text-indigo-600 font-bold hover:text-indigo-700 flex items-center group">
            View all posts 
            <svg class="w-5 h-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>

    @if ($latestBlogs->count() > 0)
        <div class="grid md:grid-cols-3 gap-10">
            @foreach ($latestBlogs as $blog)
                <article class="group bg-white dark:bg-gray-800 rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-indigo-100 dark:hover:border-indigo-900 shadow-sm hover:shadow-2xl transition-all duration-500">
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img 
                            src="{{ $blog->image ? asset('storage/' . $blog->image) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=800&auto=format&fit=crop' }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                            alt="{{ $blog->title }}"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center space-x-2 text-xs font-bold text-indigo-600 uppercase tracking-widest mb-4">
                            <span>Analysis</span>
                            <span class="text-gray-300">•</span>
                            <span class="text-gray-400">{{ $blog->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">{{ $blog->title }}</h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-8 line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($blog->content), 120) }}
                        </p>
                        <a href="{{ route('publicblog.index') }}" class="inline-flex items-center font-bold text-gray-900 dark:text-white hover:text-indigo-600 transition-colors">
                            Continue Reading
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="py-20 text-center bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700">
            <p class="text-gray-500 dark:text-gray-400 text-lg">Our library is currently expanding. Check back shortly!</p>
        </div>
    @endif
</section>
@endsection
