<?php

namespace AI\backend_php_hw5_1\Http;


class Response
{
    const OK = 200;
    const BAD_REQUEST = 400;

    /**
     * Отправляет http ответ с кодом и информационным сообщением
     *
     * @param int $code
     * @param string $message
     */
    public function send(int $code, string $message): void
    {
        http_response_code($code);
        echo $message;
    }
}
