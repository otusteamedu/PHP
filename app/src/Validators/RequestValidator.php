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

    public function validate()
    {
        if (!is_array($this->requestData)) {
            throw new AppException('error message');
        }

        return false;
    }
}