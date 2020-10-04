<?php


namespace Validator;


class Validator
{
    private \Validator\ValidatorInterface $validator;

    public function __construct(\Validator\ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate()
    {
        return $this->validator->validate();
    }
}