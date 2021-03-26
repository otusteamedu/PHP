<?php


namespace Otushw\DTOs;


class QueryDTO
{
    public int $id;
    public string $status;

    public function __construct(int $id, string $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public function __toString()
    {
        return "ID $this->id, Status $this->status";
    }
}