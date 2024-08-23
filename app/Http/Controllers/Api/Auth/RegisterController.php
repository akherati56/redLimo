<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $validate = $request->validated();

        $user = User::create([
            'name' => $validate['name'],
            'phoneNumber' => $validate['phoneNumber'],
            'bio' => $validate['bio'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ]);

        return response()->json(['register was successfull! ', $status = 200]);
    }
}
