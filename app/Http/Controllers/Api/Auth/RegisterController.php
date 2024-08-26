<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendOTPJob;
use App\Jobs\SmsOtpJob;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $validate = $request->validated();

        $validate = $request->validated();
        $otp = rand(999, 9999);

        if (Cache::get('user:' . $validate['phoneNumber'])) {
            return response()->json(['already registerd!', $status = 200]);
        }

        $user = new User([
            'name' => $validate['name'],
            'phoneNumber' => $validate['phoneNumber'],
            'bio' => $validate['bio'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ]);

        Cache::add('user:' . $validate['phoneNumber'], $user, now()->addMinutes(4));

        SendOTPJob::dispatch($validate['phoneNumber'], $otp)->onQueue('sendOtp');
        // SmsOtpJob::dispatch($validate['phoneNumber'], $otp);

        return response()->json(['register was successfull! ', $status = 200]);
    }
}
