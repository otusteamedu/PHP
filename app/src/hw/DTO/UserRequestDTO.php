<?php


namespace Otus\DTO;


class UserRequestDTO
{
    private array $conditions;

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }

}