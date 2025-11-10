@extends('layouts.app')

@section('title', 'Blogging Services - MyBlogsite')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16">

    <!-- Heading -->
    <h2 class="text-4xl md:text-5xl font-bold text-center text-indigo-600 dark:text-indigo-400 mb-6">
        Our Blogging Services
    </h2>
    <p class="text-center text-gray-700 dark:text-gray-200 max-w-3xl mx-auto mb-12">
        We help bloggers, writers, and businesses grow their online presence with tailored blogging services.
        Choose a package that fits your needs and budget.
    </p>

    <!-- Services Grid -->
    <div class="grid md:grid-cols-3 gap-8 mb-16">
        <!-- Starter Blog Package -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1">
            <div class="text-indigo-600 text-4xl mb-4">📝</div>
            <h3 class="text-2xl font-semibold mb-2">Starter Blog</h3>
            <p class="text-gray-700 dark:text-gray-200 mb-4">Perfect for new bloggers just getting started. Includes setup, template, and 2 posts per month.</p>
            <span class="inline-block bg-indigo-100 dark:bg-indigo-700 text-indigo-800 dark:text-white px-3 py-1 rounded-full font-semibold">KSh 5,000 / month</span>
        </div>

        <!-- Pro Blog Package -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 border-2 border-indigo-600 dark:border-indigo-400">
            <div class="text-indigo-600 text-4xl mb-4">🚀</div>
            <h3 class="text-2xl font-semibold mb-2">Pro Blog</h3>
            <p class="text-gray-700 dark:text-gray-200 mb-4">Advanced blogging package with SEO, content strategy, and 8 posts per month. Ideal for growing blogs.</p>
            <span class="inline-block bg-indigo-600 text-white px-3 py-1 rounded-full font-semibold">KSh 12,000 / month</span>
        </div>

        <!-- Enterprise Blog Package -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1">
            <div class="text-indigo-600 text-4xl mb-4">💼</div>
            <h3 class="text-2xl font-semibold mb-2">Enterprise Blog</h3>
            <p class="text-gray-700 dark:text-gray-200 mb-4">Full-service blogging including content creation, SEO optimization, social promotion, and 15+ posts per month.</p>
            <span class="inline-block bg-indigo-100 dark:bg-indigo-700 text-indigo-800 dark:text-white px-3 py-1 rounded-full font-semibold">KSh 25,000 / month</span>
        </div>
    </div>

    <!-- Modern Features Section -->
    <div class="mb-16">
        <h3 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-200 mb-8">Why Choose Our Services?</h3>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 text-center">
                <div class="text-indigo-600 text-5xl mb-4">⚡</div>
                <h4 class="font-semibold text-xl mb-2">Fast Setup</h4>
                <p class="text-gray-700 dark:text-gray-200">Get your blog live in days, not weeks. Focus on content, we handle the setup.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 text-center">
                <div class="text-indigo-600 text-5xl mb-4">📈</div>
                <h4 class="font-semibold text-xl mb-2">SEO Optimized</h4>
                <p class="text-gray-700 dark:text-gray-200">All posts optimized for search engines to drive traffic and improve visibility.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 text-center">
                <div class="text-indigo-600 text-5xl mb-4">🎯</div>
                <h4 class="font-semibold text-xl mb-2">Tailored Strategy</h4>
                <p class="text-gray-700 dark:text-gray-200">We design content strategies that match your niche and audience for maximum impact.</p>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-indigo-600 dark:bg-indigo-800 rounded-xl p-12 text-center text-white shadow-lg">
        <h3 class="text-3xl font-bold mb-4">Ready to start your blog journey?</h3>
        <p class="mb-6 text-lg">Pick a package, get started, and watch your blog grow with our expert support.</p>
        <a href="{{ route('contact') }}" class="inline-block bg-white text-indigo-600 dark:text-indigo-800 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100 transition">
            Get Started
        </a>
    </div>

</div>
@endsection
