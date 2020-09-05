<?php

namespace App\Http\Response;

class Response
{
    public function response(?string $data = null, int $status = 200): void
    {
        http_response_code($status);
        echo $data;
    }
}
