<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $storedToken = Redis::get('otp:' . $request['phoneNumber']);

        if ($storedToken !== $request['otp'] || $storedToken == null) {
            return response()->json(['incorrect otp']);
        }

        $user = User::where('phoneNumber', $request['phoneNumber'])->firstOrFail();
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['token' => $token], 200);
    }
}
