<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\OTPRequest;
use App\Jobs\SendOTPJob;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class OTPController extends Controller
{
    public function getOTP(OTPRequest $request)
    {
        $validate = $request->validated();
        $otp = rand(999, 9999);

        $user = User::where('phoneNumber', $validate['phoneNumber'])->first();
        $user_cache = Cache::get('user:' . $validate['phoneNumber']);

        if (!$user && !$user_cache) {
            return response()->json(['not registered yet!']);
        }

        $storedToken = Cache::get('otp:' . $validate['phoneNumber']);
        if ($storedToken) {
            return response()->json(['otp already has sent!']);
        }

        SendOTPJob::dispatch($validate['phoneNumber'], $otp)->onQueue('sendOtp');
        // SmsOtpJob::dispatch($validate['phoneNumber'], $otp);

        return response()->json(['msg' => 'otp has been sent!', 'otp' => $otp]);
    }
}
