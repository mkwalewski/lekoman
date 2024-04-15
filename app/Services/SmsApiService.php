<?php

namespace App\Services;

use Smsapi\Client\Curl\SmsapiHttpClient;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Service\SmsapiPlService;

class SmsApiService
{
    private const STATUS_QUEUE = 'QUEUE';
    private string $phone;
    private string $error;
    private SmsapiHttpClient $client;
    private SmsapiPlService $service;

    public function __construct()
    {
        $this->client = new SmsapiHttpClient();
        $this->service = $this->client->smsapiPlService(config('smsapi.token'));
        $this->phone = config('smsapi.phone');
    }

    public function getError(): ?string
    {
        return $this->error ?? null;
    }

    public function sendMessage(string $message): bool
    {
        $sms = SendSmsBag::withMessage($this->phone, $message);
        try {
            $response = $this->service->smsFeature()->sendSms($sms);
        } catch (\Exception $exception) {
            report($exception);
            $this->error = $exception->getMessage();
            return false;
        }

        return $response->status === self::STATUS_QUEUE;
    }
}
