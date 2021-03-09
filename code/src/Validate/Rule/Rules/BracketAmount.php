<?php

namespace Validate\Rule\Rules;

use Validate\Rule\Rule;

class BracketAmount extends Rule {

    /**
     * @param string $value
     * @return bool
     */
    public function check(string $value) {
        if (substr_count($value, ')') !== substr_count($value, '(')) {
            return true;
        }

        return false;
    }
}