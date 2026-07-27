<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    function blogs(){
        $blogs = Blog::orderBy('date_published', 'desc')->get();

        return view('blogs.blogs', compact('blogs'));

    }

    public function show(Request $request)
    {
        $blog = Blog::findOrFail($request->blog);

        return view('blogs.show', compact('blog'));
    }
}
