<?php

namespace App\Http\Controllers\Blogger;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('user_id', Auth::id())->latest()->paginate(6);
        return view('blogger.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('blogger.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('blogs', 'public')
            : null;

        Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('blogger.blogs.index')->with('success', 'Blog created successfully!');
    }

    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);
        return view('blogger.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $blog->image = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($request->only('title', 'content'));

        return redirect()->route('blogger.blogs.index')->with('success', 'Blog updated!');
    }

    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();
        return redirect()->route('blogger.blogs.index')->with('success', 'Blog deleted!');
    }
}
