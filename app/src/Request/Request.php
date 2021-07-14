<?php

namespace App\Request;

use App\Exceptions\AppException;
use App\Exceptions\RequestException;

class Request
{
    private array $data;

    /**
     * Request constructor.
     * @throws AppException
     */
    public function __construct()
    {
        $json = file_get_contents('php://input');

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new AppException(json_last_error_msg(), 400);
        }

        $this->data = json_decode($json, true);
    }

    public function getData(): array
    {
        return $this->data;
    }
}