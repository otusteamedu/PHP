<?php


namespace Repetitor202\Domain\DTO;


class EventSearchDTO
{
    public array $conditions;

    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }
}