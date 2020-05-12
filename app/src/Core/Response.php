<?php

namespace Core;

class Response
{
    public function send()
    {
        $result = [
            'node' => $_SERVER['SERVER_ADDR'],
            'data' => '',
        ];


        http_send_content_type('application/json');
        echo $result;
    }
}