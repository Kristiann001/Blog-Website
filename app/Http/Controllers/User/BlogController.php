<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    // Show all blogs (read-only for users)
    public function index()
    {
        $blogs = Blog::with('user')->latest()->paginate(6);
        return view('user.blogs.index', compact('blogs'));
    }

    // Show a single blog post
    public function show($slug)
    {
        $blog = Blog::with(['user', 'comments.user'])->where('slug', $slug)->firstOrFail();
        return view('user.blogs.show', compact('blog'));
    }
}
