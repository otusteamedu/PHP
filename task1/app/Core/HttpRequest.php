<?php


namespace App\Core;


use App\Api\RequestInterface;

class HttpRequest implements RequestInterface
{
    private array $get;
    private array $post;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function getQuery(string $attribute, ?string $default = null): ?string
    {
        return $this->get[$attribute] ?? $default;
    }

    public function getPost(string $attribute, ?string $default = null): ?string
    {
        return $this->post[$attribute] ?? $default;
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

}