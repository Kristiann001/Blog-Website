<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog; // Blog model

class HomeController extends Controller
{
    public function index()
    {
        // Fetch 3 most recent blogs
        $latestBlogs = Blog::latest()->take(3)->get();

        // Pass to the homepage view
        return view('home', compact('latestBlogs'));
    }

    public function blogs()
    {
        return view('blogs');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
