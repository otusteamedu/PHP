<?php


namespace Classes\Repositories;

use Slim\Psr7\Response;
use Classes\JsonHandler;

class ResponseHandler
{

    public static function getResponse (Response $response, string $message, int $success)
    {
        $result = [
            'success' => (bool) $success,
            'http_status' => $response->getStatusCode(),
            'message' => $message
        ];

        $response->getBody()->write(JsonHandler::getJson($result));
        return $response;
    }
}
