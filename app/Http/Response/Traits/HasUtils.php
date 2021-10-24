<?php

namespace App\Http\Response\Traits;

use App\Http\Response\Helpers\StatusCodes;

trait HasUtils
{
    /**
     * @param int $code
     * @param string $message
     * @param array $data
     * @return array
     */
    private function prepareResponse(int $code = 200, string $message = "", array $data = []): array
    {
        $result['code'] = $code;
        $result['status'] = ($code == StatusCodes::OK) ? "success" : "error";
        $result['message'] = $message;
        $result['data'] = $data;
        return $result;
    }
}