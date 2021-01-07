<?php

namespace App\Validator;

/**
 * Class RequestValidator
 */
class RequestValidator implements Validator
{
    const LENGTH_STRING = 5;
    /**
     * @param $val
     * @return bool
     */
    public function isValid($val): bool
    {
        if ($this->isOnlyBrackets($val) && !$this->checkBrackets($val)) {
            return false;
        }

        if (!$this->checkLength($val)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $val
     * @return bool
     */
    private function checkLength(string $val): bool
    {
        return strlen($val) >= self::LENGTH_STRING;
    }

    /**
     * @param string $val
     * @return bool
     */
    public function checkBrackets(string $val): bool
    {
        if (strlen($val) % 2 !== 0) {
            return false;
        }

        $result = 0;
        for ($i = 0; $i < strlen($val); $i++) {
            if ($val[$i] === '(' && $result >= 0) {
                $result++;
            }
            if ($val[$i] === ')' && $result >= 0) {
                $result--;
            }
        }

        if ($result === 0) {
            return true;
        }

        return false;
    }

    /**
     * @param string $val
     * @return bool
     */
    private function isOnlyBrackets(string  $val): bool
    {
        return preg_match('/^[(,)]*$/', $val);
    }
}
