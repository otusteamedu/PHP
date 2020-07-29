<?php

namespace Ozycast\App\Core;

class Response
{
    /**
     * Отправить ответ
     * @param bool $status
     * @param array $response
     * @param int $code
     */
    public function send(bool $status, array $response, int $code = 200)
    {
        header('Content-Type: application/json');

        if ($status) {
            $response = [
                'success' => $status,
                'result' => $response,
            ];
        } else {
            header("HTTP/1.1 $code");
            $response = array_merge([
                'success' => $status,
            ], $response);
        }

        echo json_encode($response);
    }
}