<?php


namespace Repetitor202;


class HttpJsonResponseService implements IResponseService
{
    public function successOutput(): void
    {
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        $result = [
            'status' => 'success',
            'message' => 'Данные корректны'
        ];
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function failedOutput(string $error): void
    {
        header("HTTP/1.1 400 Bad Request");
        header('Content-Type: application/json');
        $result = [
            'status' => 'error',
            'message' => $error
        ];
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}