<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendOTP;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

        SendOTP::dispatch($user);
    }
}
