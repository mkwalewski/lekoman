<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    const SEND_MESSAGE_URL = 'https://api.telegram.org/bot%s/sendMessage?chat_id=%s&text=%s';

    private string $token;
    private string $chatId;

    public function __construct()
    {
        $this->token = config('telegram.token');
        $this->chatId = config('telegram.chatId');
    }

    public function sendMessage(string $message): bool
    {
        $response = Http::get(sprintf(self::SEND_MESSAGE_URL, $this->token, $this->chatId, $message));

        if (!$response->successful()) {
            $response->throw();
        }

        return true;
    }
}
