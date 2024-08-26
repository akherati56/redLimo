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
        Cache::add('otp:' . $this->phoneNumber, $this->otp, 30);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
