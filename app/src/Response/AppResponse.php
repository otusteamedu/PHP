<?php

namespace Otus\Response;

class AppResponse
{
    public static function response(array $data = [], $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }
}