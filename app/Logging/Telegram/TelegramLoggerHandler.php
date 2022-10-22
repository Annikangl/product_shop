<?php


namespace App\Logging\Telegram;


use App\Services\Telegram\TelegramBotApi;
use Illuminate\Http\Client\HttpClientException;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\FormattedRecord;
use Monolog\Logger;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chatId;

    protected string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        $this->chatId = $config['chat_id'];
        $this->token = $config['token'];
        parent::__construct($level);
    }

    protected function write(array $record): void
    {
        try {
            TelegramBotApi::sendMessage($this->chatId, $this->token, $record['formatted']);
        } catch (HttpClientException $exception) {
            echo $exception->getMessage();
        }

    }
}
