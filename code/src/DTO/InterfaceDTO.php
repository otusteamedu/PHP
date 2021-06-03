<?php


namespace App\DTO;


interface InterfaceDTO
{
    public function getStatusCode(): int;
    public function getData(): array;
}
