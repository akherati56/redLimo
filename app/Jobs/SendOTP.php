<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class SendOTP implements ShouldQueue
{
    use Queueable;

    protected $phoneNumber;
    protected $otp;
    /**
     * Create a new job instance.
     */
    public function __construct(string $phoneNumber, string $otp)
    {
        $this->phoneNumber = $phoneNumber;
        $this->otp = $otp;
        // Redis::setex('otp:' . $this->phoneNumber, 30, $this->otp);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Cache::add('otp:' . $this->phoneNumber, $this->otp, 30);
    }
}
