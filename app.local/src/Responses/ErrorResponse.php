<?php

namespace Responses;

use Symfony\Component\HttpFoundation\JsonResponse;


class ErrorResponse extends JsonResponse
{
    /**
     * ErrorResponse constructor.
     *
     * @param null  $message
     * @param int   $status
     * @param array $headers
     * @param bool  $json
     */
    public function __construct($message = null, int $status = 200, array $headers = [], bool $json = false)
    {
        $responseData = [
            'status' => 'error',
            'message' => $message ?: '',
            'ip' => $_SERVER['SERVER_ADDR'],
        ];

        parent::__construct($responseData, $status, $headers, $json);
    }
}