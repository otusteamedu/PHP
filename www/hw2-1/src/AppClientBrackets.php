<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

final class AppClientBrackets
{
    private static string $URI = "http://server.hw2.test:80";
    private static string $posdata_string = "(())()";

    public static function run()
    {
        $headers = [
            'Content-Type'      => 'application/x-www-form-urlencoded'
        ];

        $body['string'] = static::$posdata_string;

        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $response = $client->post(static::$URI, ['headers' => $headers, 'form_params' => $body]);
        echo $response->getStatusCode() . " " . $response->getReasonPhrase();
    }
}
