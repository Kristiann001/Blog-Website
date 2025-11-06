<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $myBlogs = Blog::where('user_id', $userId)->count();
        $myComments = Comment::where('user_id', $userId)->count();

        return view('user.dashboard', compact('myBlogs', 'myComments'));
    }
}
