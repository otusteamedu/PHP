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
     * @throws \Rakit\Validation\RuleQuashException
     */
    public function validate()
    {
        $this->validator->addValidator('order_sum', new SumValidatorRule());
        $this->validator->addValidator('card_holder', new CardHolderValidatorRule());

        $validation = $this->validator->validate($this->requestData, [
            'card_number' => 'required|digits:16',
            'card_holder' => 'required|card_holder',
            'card_expiration' => 'required|after:' . date('Y-m-d'),
            'cvv' => 'required|digits:3',
            "order_number" => 'required',
            "sum" => "required|order_sum:100,1000000"
        ]);


        if ($validation->fails()) {
            throw new ValidationException('Validation error, reason: ' . json_encode($validation->errors()->firstOfAll()), Logger::ERROR);
        }

        return true;
    }
}