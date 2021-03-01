<?php

declare(strict_types=1);

namespace App\Http;

class Request
{

    private array $post;

    public function __construct()
    {
        $this->post = $_POST;
    }

    public function getPost(string $paramName): string
    {
        return $this->post[$paramName] ?? '';
    }

}