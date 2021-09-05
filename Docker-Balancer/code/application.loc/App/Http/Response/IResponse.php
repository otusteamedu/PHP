<?php

namespace App\Http\Response;

interface IResponse
{
    public function send(int $code = 200, string $message = "", array $data = []): void;
}