<?php

namespace App\Http\Response;

use App\Http\Response\Traits\HasUtils;

class ResponseXhr implements IResponse
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
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}