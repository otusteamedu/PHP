<?php

namespace App\Http\Response;

interface IResponse
{
    public function send($code = 200, string $message = "", array $data = []): void;
}