<?php


namespace Controllers\Contracts;


interface Curl
{
    public function send(): string;
}