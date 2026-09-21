<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Blog listing page
    public function index(Request $request)
    {
        $blogs = Blog::with('category')
            ->orderByRaw('published_at IS NULL')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(16)
            ->withQueryString();

        return view('frontend.blogs.blogs', compact('blogs'));
    }

    // Single blog page
    public function show($slug)
    {
        $blog = Blog::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $popularPosts = Blog::with('category')
            ->where('id', '!=', $blog->id)
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return view('frontend.blogs.view', compact(
            'blog',
            'popularPosts'
        ));
    }
}
