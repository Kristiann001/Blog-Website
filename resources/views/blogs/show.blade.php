@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<div class="max-w-4xl mx-auto py-16 px-6">
    <h1 class="text-4xl font-bold mb-6 text-indigo-600">{{ $blog->title }}</h1>
    @if($blog->image)
        <img src="{{ asset('storage/' . $blog->image) }}" class="w-full rounded-lg mb-6" alt="{{ $blog->title }}">
    @endif
    <div class="text-gray-700 dark:text-gray-200 prose max-w-none">
        {!! $blog->content !!}
    </div>
</div>
@endsection
