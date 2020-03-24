<?php

declare(strict_types=1);

namespace App\Kernel;

class Request implements RequestInterface
{
    private $get = [];

    private $post = [];

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function get(string $key): ?string
    {
        return isset($this->get[$key]) ? $this->get[$key] : null ;
    }

    public function getAll(): array
    {
        $result = $this->get;

        if (isset($result['uri'])) {
            unset($result['uri']);
        }

        return $result;
    }

    public function post(string $key): ?string
    {
        return isset($this->post[$key]) ? $this->post[$key] : null ;
    }

    public function getBody(): ?string
    {
        return file_get_contents('php://input');
    }
}