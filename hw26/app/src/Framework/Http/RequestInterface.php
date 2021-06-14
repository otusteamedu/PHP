<?php

declare(strict_types=1);

namespace App\Framework\Http;

interface RequestInterface
{
    public function getMethod(): string;

    public function getUriPath(): string;

    public function getPostParam($paramName): string;
}