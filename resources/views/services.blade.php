@extends('layouts.app')

@section('title', 'Our Services - Nexus Insight')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16">

<section class="relative overflow-hidden pt-16 pb-20">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#9089fc] to-[#ff80b5] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
    </div>
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-black tracking-tight text-gray-900 dark:text-white mb-6">
            Our <span class="text-indigo-600 dark:text-indigo-400">Services</span>
        </h2>
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl mx-auto">
            Scale your vision with our premium solutions. From creative insights to technical excellence, we provide the tools you need to succeed.
        </p>
    </div>
</section>

    <!-- Search Bar -->
    <!-- <div class="max-w-md mx-auto mb-12 relative">
        <input
            type="text"
            id="serviceSearch"
            placeholder="Search services..."
            aria-label="Search services"
            class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
        >
        <div class="absolute left-3 top-3 text-gray-400 dark:text-gray-500 pointer-events-none">
            🔍
        </div>
    </div> -->

    <!-- Services Grid -->
    <div id="servicesList" class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-10 max-w-7xl mx-auto px-6 mb-24">
        @foreach($services as $service)
        <div class="service-card group bg-white dark:bg-gray-800 rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-indigo-100 dark:hover:border-indigo-900 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col">
            <div class="relative aspect-[16/10] overflow-hidden">
                <img 
                    src="{{ $service->image ? asset('storage/' . $service->image) : 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop' }}" 
                    alt="{{ $service->title }}" 
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 to-transparent"></div>
                <div class="absolute bottom-4 left-4">
                    <span class="px-3 py-1 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md text-gray-900 dark:text-white text-xs font-bold rounded-full shadow-sm">
                        KSh {{ number_format($service->price, 0) }}/mo
                    </span>
                </div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <h3 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">
                    {{ $service->title }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 line-clamp-3 leading-relaxed flex-1">
                    {{ $service->description }}
                </p>

                @auth
                    <form action="{{ route('services.subscribe', $service->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 dark:shadow-none hover:bg-indigo-700 hover:-translate-y-1 transition duration-300 flex items-center justify-center group/btn">
                            Get Started
                            <svg class="w-5 h-5 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mt-auto block w-full text-center py-4 bg-gray-900 dark:bg-gray-700 text-white rounded-2xl font-bold hover:bg-gray-800 dark:hover:bg-gray-600 transition">
                        Log in to Subscribe
                    </a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>

    <!-- No Results -->
    <p id="noResults" class="text-center text-gray-500 dark:text-gray-400 mt-8 hidden">
        No services found.
    </p>

    <!-- Optional Pagination -->
    <div class="mt-8">
        {{-- Use paginate() in controller if you want pagination --}}
        {{-- {{ $services->links() }} --}}
    </div>
</div>
@endsection

@section('scripts')
<script>
const searchInput = document.getElementById('serviceSearch');
const servicesList = document.getElementById('servicesList');
const noResults = document.getElementById('noResults');

let debounceTimer;
searchInput.addEventListener('input', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const query = this.value.trim().toLowerCase();
        let hasResults = false;

        servicesList.querySelectorAll('.service-card').forEach(card => {
            const title = card.querySelector('h3').innerText.toLowerCase();
            const desc = card.querySelector('p').innerText.toLowerCase();
            if(title.includes(query) || desc.includes(query)) {
                card.style.display = 'flex';
                hasResults = true;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.classList.toggle('hidden', hasResults);
    }, 200); // Debounce: 200ms
});
</script>
@endsection
