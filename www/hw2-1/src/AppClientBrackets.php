<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

final class AppClientBrackets
{
    private static string $URI = "http://server.hw2.test:80";
    private static string $posdata_string = "(())(";

    public static function run()
    {
        $body['string'] = static::$posdata_string;

        $request = (new \Laminas\Diactoros\Request())
            ->withUri(new \Laminas\Diactoros\Uri(static::$URI))
            ->withMethod('POST')
            ->withAddedHeader('Content-Type', 'application/x-www-form-urlencoded');

        foreach ($body as $key => $value) {
            $request->getBody()->write((string) $key . '=' . (string) $value);
        }

        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $response = $client->send($request);
      
        echo $response->getStatusCode() . " " . $response->getReasonPhrase();
    }
}
