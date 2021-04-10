<?php

use GuzzleHttp\Client;

$client = new Client();
$response = $client->request('GET', ['yandex_api_uri'], [
            'query' => [
                'lat' => ['lat'],
                'lon' => ['lon'],
                'lang' => 'ru_RU',
                'limit' => 1
            ],
            'headers' => [
                'X-Yandex-API-Key' => ['yandex_api_key']
            ]
        ]);
$result = json_decode($response->getBody()->getContents(), true);
$temp = (int)$result['fact']['temp'];
$message = 'За окном ' . $temp . ' градусов';
$bot = new \TelegramBot\Api\BotApi(['telegram_bot_token']);
$bot->sendMessage(['telegram_chat_id'], $message);
