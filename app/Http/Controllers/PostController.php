<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function show(Post $post)
    {
        abort_if(!$post->is_published, 404);

        return view('posts.show', compact('post'));
    }
}
