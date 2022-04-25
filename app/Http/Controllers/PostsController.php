<?php

namespace App\Http\Controllers;

use App\Post;

class PostsController extends Controller
{
    public function index()
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $posts = Post::with('translations')->where('status',Post::PUBLISHED)->paginate('5');
        return view('posts.index', compact('posts','locale','fallbackLocale'));
    }

    public function show($slug)
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $post = Post::with('translations')->where('status',Post::PUBLISHED)->where('slug',$slug)->first();
        $post = $post->translate($locale,$fallbackLocale);
        return view('posts.show', compact('post','locale','fallbackLocale'));
    }
}
