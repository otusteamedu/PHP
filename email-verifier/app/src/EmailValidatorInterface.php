<?php

namespace App;


interface EmailValidatorInterface
{
    public function validate(string $email): void;

    public function setNext(EmailValidatorInterface $validator): EmailValidatorInterface;
}