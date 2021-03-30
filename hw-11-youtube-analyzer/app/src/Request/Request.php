<?php

namespace App\Request;

interface Request
{
    public function getResponse(string $url);
    public function sendRequest(string $url);
}