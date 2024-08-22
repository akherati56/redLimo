<?php

namespace App\Interface;

interface SmsServiceInterface
{
    /**
     * Send an SMS to the specified recipient.
     *
     * @param string $to
     * @param string $message
     * @return void
     */
    public function send(string $to, string $message);
}
