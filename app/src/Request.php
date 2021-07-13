<?php

namespace App;

use App\Exceptions\RequestException;

class Request
{
    private array $data;

    /**
     * Request constructor.
     * @throws RequestException
     */
    public function __construct()
    {
        $json = file_get_contents('php://input');

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RequestException(json_last_error_msg(), 400);
        }

        $this->data = json_decode($json, true);
    }

    public function getData(): array
    {
        return $this->data;
    }
}