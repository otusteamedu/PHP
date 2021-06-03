<?php


namespace App\DTO;


interface InterfaceDTO
{
    public function getStatusCode(): int;

    /**
     * @return \JsonSerializable|array
     */
    public function getData();
}
