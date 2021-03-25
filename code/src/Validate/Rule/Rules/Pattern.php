<?php

namespace Validate\Rule\Rules;

use Validate\Rule\Rule;

class Pattern extends Rule {

    /**
     * @param string $value
     * @return bool
     */
    public function check(string $value) :bool {

        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

        return preg_match ($pattern, $value);
    }
}