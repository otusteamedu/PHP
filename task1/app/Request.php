<?php


namespace App;


use App\Api\RequestInterface;

class Request implements RequestInterface
{
    private array $get;
    private array $post;

    public function __construct(array $get, array $post)
    {
        $this->get = $get;
        $this->post = $post;
    }

    public function getQuery(string $attribute, ?string $default = null): string
    {
        return $this->get[$attribute] ?? $default;
    }

    public function getPost(string $attribute, ?string $default = null): string
    {
        return $this->post[$attribute] ?? $default;
    }
}