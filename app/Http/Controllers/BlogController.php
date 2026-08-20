<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    // Blog listing page
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();

        return view('frontend.blogs.blogs', compact('blogs'));
    }

    // Single blog page
    public function show($slug)
{
    $blog = Blog::where('slug', $slug)
        ->firstOrFail();

    $popularPosts = Blog::where('id', '!=', $blog->id)
        ->orderBy('views', 'desc')
        ->take(5)
        ->get();

    return view('frontend.blogs.view', compact(
        'blog',
        'popularPosts'
    ));
}
}
