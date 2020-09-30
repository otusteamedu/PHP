<?php

namespace App;

class Response
{
    private int $response_code = 200;

    public function setResponseCode(int $code)
    {
        $this->response_code = $code;
    }

    public function getResponseCode()
    {
        return $this->response_code;
    }

    public function send()
    {
        http_response_code($this->response_code);
    }
}