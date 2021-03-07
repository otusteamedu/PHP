<?php

declare(strict_types=1);

namespace App\Http;

class Request
{

    public function getPost($paramName): string
    {
        return $_POST[$paramName] ?? '';
    }

}