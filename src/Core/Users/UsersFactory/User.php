<?php

namespace App\Core\Users\UsersFactory;

abstract class User
{
    protected array $rules;
    abstract public function getRules(): array;
    abstract public function setRules(array $rules): void;
}