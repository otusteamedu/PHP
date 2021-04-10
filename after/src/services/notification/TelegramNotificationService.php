<?php

namespace Src\services\notification;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;

class TelegramNotificationService implements NotificationServiceInterface
{
    private BotApi $bot;

    public function __construct()
    {
        $this->bot = new BotApi($_ENV['telegram_bot_token']);
    }

    public function sendTemperatureMessage(float $temperature)
    {
        try {
            $message = 'За окном ' . $temperature . ' градусов';
            $this->bot->sendMessage($_ENV['telegram_chat_id'], $message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}