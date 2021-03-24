<?php

namespace Validate\Rule\Rules;

use Validate\Rule\Rule;

class Mx extends Rule {

    /**
     * @param string $value
     * @return bool
     */
    public function check(string $value) :bool {

        $parts = explode('@', $value);

        $host = $parts[1] ?? '';

        if ($host === '')
            return false;

        if (checkdnsrr($host, "MX")) {
            return true;
        }

        return false;
    }
}