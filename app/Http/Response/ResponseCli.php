<?php

namespace App\Http\Response;

use App\Http\Response\Traits\HasUtils;

class ResponseCli implements IResponse
{
    use HasUtils;

    /**
     * @param int $code
     * @param string $message
     * @param array $data
     */
    public function send($code = 200, string $message = "", array $data = []): void
    {
        $result = $this->prepareResponse($code, $message, $data);
        extract($result);
        echo sprintf("status: %s, code: %d, message: %s, data=" . print_r($data, true), $status, $code, $message);
    }
}