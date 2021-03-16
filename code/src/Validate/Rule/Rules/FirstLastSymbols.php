<?php

namespace Validate\Rule\Rules;

use Validate\Rule\Rule;

class FirstLastSymbols extends Rule {

    /**
     * @param string $value
     * @return bool
     */
    public function check(string $value) {
        if ( substr($value, 0, 1) == ')' || substr($value, -1) == '(' ) {
            return true;
        }

        return false;
    }
}