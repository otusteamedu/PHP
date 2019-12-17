<?php


namespace App\Commands\Entity;


interface ResultInterface
{
    public function __construct($result);
    public function getStringResult(): string;
    public function getIntResult(): string;
    public function getFloatResult(): string;
}