<?php

namespace App\Factory;

use App\Http\Response\Response;
use App\Interfaces\ResponseInterface;

class ResponseFactory
{
    public static function createResponse(int $statusCode = 200, array $headers = [], $content = ''): ResponseInterface {
        return new Response($statusCode, $headers, $content);
    }
}