<?php


namespace App\Entity\DTO;


use JsonSerializable;

interface InterfaceDTO extends JsonSerializable
{
    public function getStatusCode(): int;
}
