<?php


namespace Otushw;


class UserRequestDTO
{
    public array $conditions;

    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }
}