<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function getIndex() {
        $date = Carbon::now();
        $posts = Post::latest('id')->paginate('5');
        return view('blog.index', compact('posts', 'date'));
    }

    public function getSingle($slug) {
        $date = Carbon::now();
        $post = Post::where('slug', '=', $slug)->first();
        return view('blog.single', compact('post', 'date'));
    }
} 
