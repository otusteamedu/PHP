<?php

namespace Brackets\Controllers;

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
    protected function getHttpResponseText($code): string
    {
        if ($code !== NULL) {

            switch ($code) {
                case 200: $text = 'OK'; break;
                case 400: $text = 'Bad Request'; break;
                default: $text = 'Unknown status code'; break;
            }

            return $text;
        }
    } 
}