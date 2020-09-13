<?php

namespace App\Http\Response;

class Response
{
    /**
     * @var mixed $body
     */
    private $body;

    public function __construct($body = null, int $status = 200)
    {
        $this->body = $body;
        http_response_code($status);
    }

    public function send()
    {
        header("Content-type: application/json; charset=utf-8");
        echo json_encode([
            'server_ip' => $_SERVER['SERVER_ADDR'],
            'data' => $this->body
        ]);
    }
}
