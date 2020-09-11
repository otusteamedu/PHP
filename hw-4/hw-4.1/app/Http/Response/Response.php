<?php

namespace App\Http\Response;

class Response
{
    public function setStatus(int $status = 200): void
    {
        http_response_code($status);
    }
}
