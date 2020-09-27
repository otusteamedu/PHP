<?php

namespace Views;

use JsonException;

class ApiJsonView
{
    /**
     * @param $data
     * @param int $status
     * @throws JsonException
     */
    public function response($data, $status = 500): void
    {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    private function requestStatus($code): string
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ?: $status[500];
    }
}