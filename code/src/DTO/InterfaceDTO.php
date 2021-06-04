<?php


namespace App\DTO;


use JsonSerializable;

interface InterfaceDTO extends JsonSerializable
{
    public function getStatusCode(): int;
}
