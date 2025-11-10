@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-16 px-6">
  <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Contact Us</h1>
    <p class="text-gray-600 text-center mb-8">
      Have questions or feedback? We’d love to hear from you.
    </p>

    <form class="space-y-6">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" id="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Enter Your Name">
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Enter Your Email">
      </div>

      <div>
        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
        <textarea id="message" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Your message..."></textarea>
      </div>

      <div class="text-center">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
          Send Message
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
