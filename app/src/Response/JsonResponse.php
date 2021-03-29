<?php


namespace Otus\Response;


class JsonResponse
{
    public static function respond(array $data, int $status = 200)
    {
        header("Content-type: application/json; charset=utf-8");
        http_response_code($status);
        return json_encode($data);
    }
}