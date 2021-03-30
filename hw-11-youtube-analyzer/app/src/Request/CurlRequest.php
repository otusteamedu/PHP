<?php

namespace App\Request;

use Exception;

class CurlRequest implements Request
{
    public function getResponse (string $url)
    {
        return self::sendRequest($url);
    }

    public function sendRequest (string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        if (empty($response)) {
            throw new Exception('Empty response');
        }
        curl_close($ch);

        return $response;
    }
}