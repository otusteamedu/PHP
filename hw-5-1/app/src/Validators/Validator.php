<?php

namespace Validators;

abstract class Validator
{
    private $next;

    public function linkWith (Validator $next): Validator
    {
        $this->next = $next;

        return $next;
    }

    public function check (string $string): bool
    {
        if (!$this->next) {
            return true;
        }

        return $this->next->check($string);
    }
}