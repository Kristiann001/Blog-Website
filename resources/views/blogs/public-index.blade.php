@extends('layouts.app')

@section('title', 'Insights - Nexus Insight')

@section('content')
<section class="relative overflow-hidden pt-16 pb-20">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#9089fc] to-[#ff80b5] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
    </div>
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-black tracking-tight text-gray-900 dark:text-white mb-6">
            The <span class="text-indigo-600 dark:text-indigo-400">Knowledge Hub</span>
        </h2>
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl mx-auto">
            Deep dives into technology, strategy, and the future of innovation. Curated for the curious mind.
        </p>
    </div>
</section>

<section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
        @if($blogs->count())
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($blogs as $blog)
                <article class="group bg-white dark:bg-gray-800 rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-indigo-100 dark:hover:border-indigo-900 shadow-sm hover:shadow-2xl transition-all duration-500">
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img 
                            src="{{ $blog->image ? asset('storage/' . $blog->image) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=800&auto=format&fit=crop' }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                            alt="{{ $blog->title }}"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 to-transparent"></div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center space-x-2 text-xs font-bold text-indigo-600 uppercase tracking-widest mb-4">
                            <span>Insight</span>
                            <span class="text-gray-300">•</span>
                            <span class="text-gray-400">{{ $blog->created_at->diffForHumans() }}</span>
                        </div>
                        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors line-clamp-2 min-h-[4rem]">
                            {{ $blog->title }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mb-8 line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($blog->content), 120) }}
                        </p>
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-3 text-sm font-medium text-gray-500 dark:text-gray-400">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-gray-700 flex items-center justify-center text-indigo-600">
                                    {{ substr($blog->user->name ?? 'U', 0, 1) }}
                                </div>
                                <span>{{ $blog->user->name ?? 'Unknown' }}</span>
                            </div>
                            <a href="{{ route('publicblog.show', $blog->slug) }}" 
                               class="inline-flex items-center font-bold text-indigo-600 hover:text-indigo-700 transition">
                                Read
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-20 flex justify-center">
                {{ $blogs->links('pagination::tailwind') }}
            </div>
        @else
            <div class="py-20 text-center bg-white dark:bg-gray-800 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700">
                <p class="text-gray-500 dark:text-gray-400 text-lg">No insights found yet. Check back shortly!</p>
            </div>
        @endif
    </div>
</section>
@endsection
