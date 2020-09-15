<?php

namespace Source;

class HttpResponses
{
    private $statusCode;

    public function __construct($code)
    {
        $this->statusCode = $code;
    }

    /**
     * Функция выбора ответа клиенту
     * @param int|string
     * @return string
     */
    public static function response(int $code, ?string $error = null): string
    {
        if ($code !== NULL) {
            $error = ($error !== NULL) ? ': ' . $error : '';

            switch ($code) {
                case 200: $text = "OK$error"; break;
                case 400: $text = "Bad Request$error"; break;
                default: $text = "Unknown status code$error"; break;
            }

            return $text;
        }
    }
}
