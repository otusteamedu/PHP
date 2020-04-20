<?php

namespace App;

class Responce
{
    protected $data;
    protected int $code;

    public function __construct($data, int $code = 200)
    {
        $this->data = $data;
        $this->code = $code;
    }

    public static function error(int $code): self
    {
        return new self(null, $code);
    }

    public function emit(): void
    {
        http_response_code($this->code);
        if (null !== $this->data) {
            header('Content-Type: application/json');
            /** @noinspection PhpUnhandledExceptionInspection */
            echo json_encode($this->data, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT);
        }
    }
}
