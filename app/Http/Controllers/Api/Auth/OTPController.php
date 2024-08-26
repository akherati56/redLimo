<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\OTPRequest;
use App\Jobs\SendOTP;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class OTPController extends Controller
{
    public function getOTP(OTPRequest $request)
    {
        $validate = $request->validated();
        $otp = rand(100000, 999999);

        // $storedToken = Redis::get('otp:' . $validate['phoneNumber']);
        $storedToken = Cache::get('otp:' . $validate['phoneNumber']);

        if ($storedToken) {
            return response()->json(['otp already has sent!']);
        }

        SendOTP::dispatch($validate['phoneNumber'], $otp);
        // SmsOtpJob::dispatch($validate['phoneNumber'], $otp);

        return response()->json(['otp has been sent!' . ' here is value of otp for test: ' . $otp]);
    }
}
