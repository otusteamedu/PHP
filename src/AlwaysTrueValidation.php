<?php

namespace HW7_1;

class AlwaysTrueValidation extends AbstractBaseValidation
{
    /**
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool
    {
        return true;
    }
}
