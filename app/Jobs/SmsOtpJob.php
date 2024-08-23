<?php

namespace App\Jobs;

use App\Interface\SmsServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsOtpJob implements ShouldQueue
{
    use Queueable;

    protected $smsService;
    protected $phoneNumber;
    protected $otp;

    // Inject the service via the constructor
    public function __construct(string $phoneNumber, string $otp, SmsServiceInterface $smsService)
    {
        $this->smsService = $smsService;
        $this->phoneNumber = $phoneNumber;
        $this->otp = $otp;
    }

    // The handle method to execute the job
    public function handle()
    {
        $this->smsService->send($this->phoneNumber, $this->otp);
    }
}
