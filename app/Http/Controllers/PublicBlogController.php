<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    // List all blogs for guests
    public function index()
    {
        $blogs = Blog::latest()->paginate(6); // paginate for nice listing
        return view('blogs.public-index', compact('blogs'));
    }

    // Show single blog for guests
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('blogs.public-show', compact('blog'));
    }
}
