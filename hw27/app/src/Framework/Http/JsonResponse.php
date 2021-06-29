<?php

declare(strict_types=1);

namespace App\Framework\Http;

class JsonResponse extends Response
{
    public function __construct(int $statusCode, $content)
    {
        parent::__construct($statusCode, json_encode($content));

        $this->addHeader('Content-Type', 'application/json');
    }
}