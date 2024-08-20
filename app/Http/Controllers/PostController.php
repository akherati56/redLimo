<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function post(Post $request)
    {

        $request->save();

        return 'success! ';
    }

    public function show(Post $request)
    {

        $posts = Post::paginate(10);


        return $posts;
    }

    public function edit(Post $request)
    {

    }

    public function delete(Post $request)
    {

    }
}
