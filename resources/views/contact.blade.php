@extends('layouts.app')

@section('title', 'Contact Us - Nexus Insight')

@section('content')
<main class="bg-white dark:bg-gray-950 min-h-screen">
    {{-- Cinematic Hero Section --}}
    <section class="relative overflow-hidden pt-24 pb-20">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#9089fc] to-[#ff80b5] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
        </div>
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-black tracking-tight text-gray-900 dark:text-white mb-6">
                Let's <span class="text-indigo-600 dark:text-indigo-400">Connect</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl mx-auto">
                Have a vision to share or a question to ask? Our team is ready to help you navigate the next frontier of innovation.
            </p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 pb-32">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            {{-- Left Column: Contact Info & Glassmorphic Cards --}}
            <div class="space-y-8">
                <div class="grid gap-6">
                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-3xl p-8 border border-gray-100 dark:border-gray-800 hover:border-indigo-100 dark:hover:border-indigo-900 transition-all duration-300">
                        <div class="flex items-center space-x-6">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Email Us</h3>
                                <p class="text-gray-600 dark:text-gray-400">hello@nexusinsight.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-3xl p-8 border border-gray-100 dark:border-gray-800 hover:border-indigo-100 dark:hover:border-indigo-900 transition-all duration-300">
                        <div class="flex items-center space-x-6">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Our Studio</h3>
                                <p class="text-gray-600 dark:text-gray-400">Nairobi, innovation Hub, level 4</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-3xl p-8 border border-gray-100 dark:border-gray-800 hover:border-indigo-100 dark:hover:border-indigo-900 transition-all duration-300">
                        <div class="flex items-center space-x-6">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Response Time</h3>
                                <p class="text-gray-600 dark:text-gray-400">Typically within 12-24 hours</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8">
                    <h4 class="text-sm font-black uppercase tracking-widest text-indigo-600 mb-6">Social Frontier</h4>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition duration-300 font-bold">LinkedIn</a>
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition duration-300 font-bold">X (Twitter)</a>
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition duration-300 font-bold">Instagram</a>
                    </div>
                </div>
            </div>

            {{-- Right Column: Contact Form --}}
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 p-10 md:p-12 shadow-2xl relative">
                @if(session('success'))
                    <div class="absolute inset-x-10 top-12 bg-green-500/10 border border-green-500/20 text-green-600 dark:text-green-400 p-4 rounded-2xl text-center mb-10 font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-8 {{ session('success') ? 'mt-32' : '' }}">
                    @csrf
                    <div class="space-y-6">
                        <div class="relative group">
                            <label for="name" class="absolute -top-3 left-4 px-2 bg-white dark:bg-gray-900 text-xs font-bold text-gray-400 group-focus-within:text-indigo-600 transition-colors">Your Identity</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full bg-transparent border-2 border-gray-100 dark:border-gray-800 rounded-2xl px-6 py-4 focus:outline-none focus:border-indigo-600 dark:text-white transition-all duration-300"
                                   placeholder="Full Name">
                            @error('name') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
                        </div>

                        <div class="relative group">
                            <label for="email" class="absolute -top-3 left-4 px-2 bg-white dark:bg-gray-900 text-xs font-bold text-gray-400 group-focus-within:text-indigo-600 transition-colors">Digital Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full bg-transparent border-2 border-gray-100 dark:border-gray-800 rounded-2xl px-6 py-4 focus:outline-none focus:border-indigo-600 dark:text-white transition-all duration-300"
                                   placeholder="email@nexusinsight.com">
                            @error('email') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
                        </div>

                        <div class="relative group">
                            <label for="message" class="absolute -top-3 left-4 px-2 bg-white dark:bg-gray-900 text-xs font-bold text-gray-400 group-focus-within:text-indigo-600 transition-colors">The Message</label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full bg-transparent border-2 border-gray-100 dark:border-gray-800 rounded-2xl px-6 py-4 focus:outline-none focus:border-indigo-600 dark:text-white transition-all duration-300"
                                      placeholder="What's on your mind?">{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-500 text-xs mt-2 ml-4">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gray-900 dark:bg-indigo-600 text-white rounded-2xl py-5 font-black text-lg shadow-xl shadow-indigo-100 dark:shadow-none hover:bg-gray-800 dark:hover:bg-indigo-700 hover:-translate-y-1 transition duration-300 flex items-center justify-center group/btn">
                        Transmit Message
                        <svg class="w-6 h-6 ml-3 group-hover/btn:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
