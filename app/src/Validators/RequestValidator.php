<?php

namespace Otus\Validators;

use Otus\Exceptions\AppException;

class RequestValidator
{
    private $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * @return void
     * @throws AppException
     */
    public function validate(): void
    {
        if (!is_array($this->requestData)) {
            throw new AppException('validation error');
        }
    }
}