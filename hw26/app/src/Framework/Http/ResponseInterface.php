<?php

declare(strict_types=1);

namespace App\Framework\Http;

interface ResponseInterface
{
    public function send(): void;
}