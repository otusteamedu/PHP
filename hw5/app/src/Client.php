<?php


namespace HW;


class Client
{

    public static function send($string)
    {
        $url = "http://" . $_SERVER['SERVER_ADDR'] . "/index.php";
        return file_get_contents($url, false, self::getContext(['string' => $string]));
    }

    private static function getContext($postData)
    {
        $options = [
            'http' => [
                'method' => 'POST',
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'content' => http_build_query($postData),
                'ignore_errors' => true
            ]
        ];
        return stream_context_create($options);
    }
}