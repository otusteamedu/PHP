<?php

declare(strict_types=1);

namespace App;

class Response
{
    public function send($data, $debug = false)
    {
        if ($debug) {
            echo '<pre>';
            var_dump($data);
        }

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($data);
    }
}