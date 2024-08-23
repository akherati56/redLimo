<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendOTP;
use App\Jobs\SmsOtpJob;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $validate = $request->validated();

        $validate = $request->validated();
        $otp = rand(100000, 999999);

        $user = User::create([
            'name' => $validate['name'],
            'phoneNumber' => $validate['phoneNumber'],
            'bio' => $validate['bio'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ]);

        SendOTP::dispatch($validate['phoneNumber'], $otp);
        // SmsOtpJob::dispatch($validate['phoneNumber'], $otp);

        return response()->json(['register was successfull! ', $status = 200]);
    }
}
