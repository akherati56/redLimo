<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // $request = $request->request();

        $user = User::create([
            'name' => $request['name'],
            'phoneNumber' => $request['phoneNumber'],
            'bio' => $request['bio'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $otp = rand(100000, 999999);

        Redis::setex('otp:' . $request['phoneNumber'], 600, $otp);

        return $otp;

    }

    public function login(Request $request)
    {
        // return $request;
        $storedToken = Redis::get('otp:' . $request['phoneNumber']);

        if ($storedToken !== $request['otp'] || $storedToken == null) {
            return response()->json(['incorrect otp']);
        }

        $user = User::find(1);
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['token' => $token], 200);
    }
}
