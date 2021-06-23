<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\Framework\Http\Response;
use App\Framework\Http\ResponseInterface;

class AbstractController
{
    protected function createSuccessResponse(string $content): ResponseInterface
    {
        return new Response(200, $content);
    }

    protected function createFailResponse(string $content): ResponseInterface
    {
        return new Response(400, $content);
    }

    protected function getCurrentUserId(): string
    {
        return 'user-id';
    }
}