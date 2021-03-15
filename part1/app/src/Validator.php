<?php

namespace App;

/**
 * Class Validator
 *
 * @package App
 */
class Validator
{
    private const STRING_LENGTH = 15;

    /**
     * @param string $string
     *
     * @return bool
     * @throws \Exception
     */
    public function isValid(string $string): bool
    {
        return $this->isNotEmpty($string) && $this->isLengthEqual($string) && $this->isBalanced($string);
    }

    /**
     * @param $string
     *
     * @return bool
     * @throws \Exception
     */
    public function isLengthEqual(string $string): bool
    {
        $this->isNotEmpty($string);

        if (strlen($string) >= self::STRING_LENGTH) {
            Responser::responseFail('String length longer, than necessary');
        }

        return true;
    }

    /**
     * @param string $string
     *
     * @return bool
     * @throws \Exception
     */
    public function isNotEmpty(string $string): bool
    {
        if (empty($string)) {
            Responser::responseFail('String is empty');
        }

        return true;
    }

    /**
     * @param string $brackets
     *
     * @return bool
     * @throws \Exception
     */
    public function isBalanced(string $brackets): bool
    {
        $stack = [];
        $length = strlen($brackets);
        for ($i = 0; $i < $length; $i++) {
            $curr = $brackets[$i];
            if ($curr === '(') {
                array_push($stack, $curr);
            } elseif ($curr = ')') {
                if (empty($stack)) {
                    return false;
                }
                array_pop($stack);
            }
        }

        if (count($stack) !== 0) {
            Responser::responseFail('Brackets is not balanced');
        }

        return true;
    }
}