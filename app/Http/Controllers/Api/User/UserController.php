<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
