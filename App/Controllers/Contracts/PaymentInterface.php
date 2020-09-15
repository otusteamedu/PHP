<?php


namespace Controllers\Contracts;


interface PaymentInterface
{
    public function pay(): string;
}