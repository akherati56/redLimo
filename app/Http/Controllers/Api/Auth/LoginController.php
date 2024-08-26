<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $storedToken = Cache::get('otp:' . $request['phoneNumber']);

        if (!$storedToken) {
            return response()->json(['OTP hasnt instanciated yet!']);
        }

        if ($storedToken !== $request['otp'] || $storedToken == null) {
            return response()->json(['incorrect otp']);
        }

        $user = Cache::get('user:' . $request['phoneNumber']);
        if ($user) {
            $user->save();
        }

        Cache::forget('otp:' . $request['phoneNumber']);
        Cache::forget('user:' . $request['phoneNumber']);

        $user = User::where('phoneNumber', $request['phoneNumber'])->first();
        if (!$user) {
            return response()->json(['msg' => 'user creation faild!'], 200);
        }

        $token = $user->createToken('Personal Access Token')->accessToken;
        return response()->json(['token' => $token], 200);
    }
}
