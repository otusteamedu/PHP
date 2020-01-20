<?php

namespace shaydurov\brackets;

class Response
{
    /**
     * sends http response along with message
     *
     * @param int $code
     * @param string $message
     */
    public function sendResponce($code, $message)
    {
        http_response_code($code);
        echo $message;
    }
}