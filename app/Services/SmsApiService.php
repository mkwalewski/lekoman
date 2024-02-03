<?php

namespace App\Services;

use Smsapi\Client\Curl\SmsapiHttpClient;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Service\SmsapiPlService;

class SmsApiService
{
    private const STATUS_QUEUE = 'QUEUE';
    private string $phone;
    private SmsapiHttpClient $client;
    private SmsapiPlService $service;

    public function __construct()
    {
        $this->client = new SmsapiHttpClient();
        $this->service = $this->client->smsapiPlService(config('smsapi.token'));
        $this->phone = config('smsapi.phone');
    }

    public function sendMessage(string $message): bool
    {
        $sms = SendSmsBag::withMessage($this->phone, $message);
        $response = $this->service->smsFeature()->sendSms($sms);

        return $response->status === self::STATUS_QUEUE;
    }
}
