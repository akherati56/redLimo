<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $request)
    {
        $user = Auth::user();
        $posts = $user->posts()->orderBy('created_at', 'desc')->with([
            'comments' => function ($query) {
                $query->take(2);
            }
        ])->paginate(10);

        return $posts;
    }
}
