<?php


namespace App\Commands\Entity;


class ResultSimple implements ResultInterface
{
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function getStringResult(): string
    {
        return (string)$this->result;
    }

    public function getIntResult(): string
    {
        return (int)$this->result;
    }

    public function getFloatResult(): string
    {
        return (float)$this->result;
    }
}