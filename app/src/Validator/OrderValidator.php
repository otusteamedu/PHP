<?php

namespace Otus\Validator;

use Monolog\Logger;
use Otus\Exceptions\ValidationException;
use Rakit\Validation\Validator;

class OrderValidator
{
    private array $requestData;
    private Validator $validator;

    public function __construct(array $requestData)
    {
        $this->validator = new Validator();
        $this->requestData = $requestData;
    }

    /**
     * @return bool
     * @throws ValidationException
     */
    public function validate()
    {
        $validation = $this->validator->validate($this->requestData, [
            'card_number' => 'required|digits:16',
            'card_holder' => 'required|alpha_spaces',
            'card_expiration' => 'required|date',
            'cvv' => 'required|digits:3',
            "order_number" => 'required',
            "sum" => "required"
        ]);


        if ($validation->fails()) {
            throw new ValidationException('Validation error, reason: ' . json_encode($validation->errors()->firstOfAll()), Logger::ERROR);
        }

        return true;
    }
}