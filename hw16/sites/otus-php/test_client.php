<?php

declare(strict_types=1);

use Symfony\Component\HttpClient\HttpClient;

require 'vendor/autoload.php';

const TICKET_BOOKING_URL = 'http://nginx/ticket_booking';
const QUEUE_RESULT_URL = 'http://nginx/queue_result';
const TEST_BOOKING_FILE = 'testJob.json';
const TEST_BOOKING_RESULT_FILE = 'testQueueResult.json';

$client = HttpClient::create();

$response = $client->request('POST', TICKET_BOOKING_URL, [
    'body' => fopen($_SERVER['DOCUMENT_ROOT'] . TEST_BOOKING_FILE, 'r')
]);

$messageId = $response->getContent();
var_dump("Сообщение {$messageId} отправлено");

while ($response = $client->request('POST', QUEUE_RESULT_URL, [
    'body' => fopen($_SERVER['DOCUMENT_ROOT'] . TEST_BOOKING_RESULT_FILE, 'r')
])) {
    if ($result = $response->getContent()) {
        var_dump("Запрос сообщения {$messageId} обработан");
        var_dump($result);
        break;
    }
}
