<?php

namespace Otus;

class Answer
{
    const headerStatus = [
            200 => 'HTTP/1.1 200 OK',
            400 => 'HTTP/1.1 400 Bad Request'
        ];

    private function generateAnswer($status,$message): void
    {
        header(self::headerStatus[$status]);
        header('Content-Type: application/json');
        $result = [
            'status' => 'success',
            'message' => $message
        ];
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public static function correctAnswer($message): void
    {
        self::generateAnswer(200,$message);
    }

    public static function errorAnswer($message): void
    {
        self::generateAnswer(400,$message);
    }
}