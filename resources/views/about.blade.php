@extends('layouts.app')

@section('title', 'About - MyBlogsite')

@section('content')
<section class="pt-12 pb-20 max-w-5xl mx-auto px-6">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-indigo-600 mb-4">About MyBlogsite</h2>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            MyBlogsite is a community-driven platform created to inspire, educate, and connect readers through stories, tutorials, and real-world insights.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-10 items-center mb-16">
        <img src="{{ asset('images/abt1.png') }}" alt="Our Story" class="rounded-2xl shadow-md">
        <div>
            <h3 class="text-2xl font-semibold mb-4 text-indigo-600">Our Story</h3>
            <p class="text-gray-700 leading-relaxed">
                Founded in 2025, MyBlogsite started as a small idea — a space where passionate writers and creators could share their thoughts freely. 
                Over time, it has grown into a thriving online publication with contributors from all over the world.
            </p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h3 class="text-2xl font-semibold mb-4 text-indigo-600">Our Mission</h3>
            <p class="text-gray-700 leading-relaxed">
                Our mission is simple: to empower people with meaningful stories, reliable information, and creative inspiration. 
                Whether it’s technology, lifestyle, or personal growth — we aim to publish content that sparks ideas and ignites curiosity.
            </p>
        </div>
        <img src="{{ asset('images/abt2.jpeg') }}" alt="Our Mission" class="rounded-2xl shadow-md">
    </div>
</section>
@endsection
