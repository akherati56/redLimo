<?php

namespace App\Services;

use App\Interface\SmsServiceInterface;
use GuzzleHttp\Client;

class SmsIrService implements SmsServiceInterface
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client(); // Guzzle HTTP client
        $this->apiKey = config('services.smsir.api_key');
    }

    public function send(string $to, string $message)
    {
        $response = $this->client->post('https://api.sms.ir/v1/send', [
            'json' => [
                'apiKey' => $this->apiKey,
                'to' => $to,
                'message' => $message,
            ],
        ]);

        // Handle the response from SMS.ir API
        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody['status'] !== 'success') {
            throw new \Exception('SMS sending failed: ' . $responseBody['message']);
        }
    }
}
