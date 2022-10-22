<?php


namespace App\Services\Telegram;


use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot/';

    /**
     * @throws HttpClientException
     */
    public static function sendMessage(int $chatId, string $token, string $text): bool
    {
        $response = Http::get(self::HOST . $token . '/sendMessage', [
            'chat_id' => $chatId,
            'text' => $text
        ]);

        if (!$response->json('ok')) {
            throw new HttpClientException($response->body());
        }

        return true;
    }
}
