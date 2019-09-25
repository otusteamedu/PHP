#!/usr/bin/php -q
<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;

require __DIR__ . '/vendor/autoload.php';

$client = new Client();

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
