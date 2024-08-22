<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Redis;

class SendOTP implements ShouldQueue
{
    use Queueable;


    protected $user;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $otp = rand(100000, 999999);

        Redis::setex('otp:' . $this->user->phoneNumber, 600, $otp);
    }
}
