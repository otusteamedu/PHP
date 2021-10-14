<?php

namespace App\Http\Response;

use App\Http\Response\Helpers\StatusCodes;
use App\Http\Response\Traits\HasUtils;

class ResponseHttp implements IResponse
{
    use HasUtils;

    /**
     * @param int $code
     * @param string $message
     * @param array $data
     */
    public function send($code = 200, string $message = "", array $data = []): void
    {
        $code = ($code === 0) || (is_string($code))
            ? StatusCodes::SERVER_ERROR
            : $code;
        http_response_code($code);
        $status = StatusCodes::getMessage($code);
        header('Status: ' . $status);
        $result = $this->prepareResponse($code, $message, $data);
        print_r($result);
    }
}