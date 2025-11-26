@extends('layouts.app')

@section('title', 'Our Services - MyBlogsite')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16">

    <!-- Heading -->
    <h2 class="text-4xl md:text-5xl font-bold text-center text-indigo-600 dark:text-indigo-400 mb-6">
        Our Services
    </h2>
    <p class="text-center text-gray-700 dark:text-gray-200 max-w-3xl mx-auto mb-12">
        Browse and find the service you need.
    </p>

    <!-- Search Bar -->
    <div class="max-w-md mx-auto mb-12 relative">
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
    </div>

    <!-- Services Grid -->
    <div id="servicesList" class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-8">
        @foreach($services as $service)
        <div class="service-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transform transition hover:-translate-y-1 flex flex-col">
            @if($service->image)
            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
            @endif
            <div class="flex-1">
                <h3 class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">{{ $service->title }}</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $service->description }}</p>
                <span class="inline-block bg-indigo-100 dark:bg-indigo-700 text-indigo-800 dark:text-white px-3 py-1 rounded-full font-semibold">
                    starting from <br> KSh {{ number_format($service->price, 2) }} per month
                </span>
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
