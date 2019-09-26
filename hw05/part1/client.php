#!/usr/bin/php -q
<?php

use GuzzleHttp\{Client, RequestOptions};
use GuzzleHttp\Exception\ClientException;

require __DIR__ . '/bootstrap.php';

/** @var Client $client */
$client = $container['http_client'];

try {
    $response = $client->post('localhost', [
        RequestOptions::FORM_PARAMS => [
            'string' => '(()()()()))((((()()()))(()()()(((())))))',
        ]
    ]);
} catch (ClientException $e) {
    $response = $e->getResponse();
    echo "Request Error\n";
}

echo "Status Code: {$response->getStatusCode()}\n";
echo "Message: {$response->getBody()}\n";
