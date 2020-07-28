<?php

namespace Ozycast\App\Core;

use Ozycast\App\App;

class Controller
{
    public function __construct()
    {
        header('Content-Type: application/json');
        if (static::$auth && !App::$user) {
            $this->response(false, ['message' => 'Ошибка авторизации'], 401);
            exit;
        }
    }

    public function response(bool $status, array $response, int $code = 200)
    {
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