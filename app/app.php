<?php

namespace Otus;

/**
 * Check if the $input is not empty and all open brackets '(' are closed with ')'
 *
 * @param $input
 * @return bool
 */
function validateBrackets($input): bool {
    if (empty($input)) {
        return false;
    }

    $result = 0;
    foreach (str_split($input) as $char) {
        if ($char === '(') {
            $result++;
        } elseif ($char === ')') {
            $result--;
        }

        if ($result < 0) {
            return false;
        }
    }

    return $result === 0;
}