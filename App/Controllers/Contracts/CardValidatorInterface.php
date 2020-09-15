<?php


namespace Controllers\Contracts;


interface CardValidatorInterface
{
    public function isValidCardNumber(string $cardNumber): bool;
    public function isValidCardHolder(string $cardHolder): bool;
    public function isValidCardExpiration(string $cardExpiration): bool;
    public function isValidCVV(int $cvv): bool;
}