<?php

declare(strict_types=1);

namespace App\Kernel;

class Response
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function send($debug = false)
    {
        if ($debug) {
            echo '<pre>';
            var_dump($this->data);
        } else {
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode($this->data);
        }
    }
}