<?php


namespace Otus\Response;


class JsonResponse
{
    public static function showMessage(string $string, int $status = 200)
    {
        header("Content-type: application/json; charset=utf-8");
        http_response_code($status);
        echo $string;
    }

    public static function showResult($data, int $status = 200)
    {
        header("Content-type: application/json; charset=utf-8");
        http_response_code($status);
        print_r($data);
    }
}