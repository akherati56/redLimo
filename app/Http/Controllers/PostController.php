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
}
