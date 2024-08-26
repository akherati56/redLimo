<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class SendOTPJob implements ShouldQueue
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
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Cache::add('otp:' . $this->phoneNumber, $this->otp, 30);
    }
}
