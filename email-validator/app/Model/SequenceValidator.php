<?php

namespace App\Model;

use App\Api\ValidatorInterface;

class SequenceValidator implements ValidatorInterface
{
    protected array $opens = ['(', '[', '{'];
    protected array $closes = [')', ']', '}'];

    /**
     * @param string $input
     * @return bool
     */
    public function validate($input): bool
    {
        if (is_null($input) || !is_string($input) || strlen($input) <= 0) {
            return false;
        }
        return $this->sequenceIsValid($input);

    }

    private function sequenceIsValid(string $input): bool
    {
        $stack = [];
        $supported = implode('', array_merge($this->opens, $this->closes));
        try {
            for ($i = 0, $len = strlen($input) - 1; $i <= $len; $i++) {
                $char = $input[$i];
                if (strpos($supported, $char) === false) {
                    return false;
                }
                if (array_search($char, $this->opens) !== false) {
                    array_push($stack, $char);
                } elseif (($closeIndex = array_search($char, $this->closes)) !== false) {
                    $lastChar = array_pop($stack);
                    if ($lastChar === null) {
                        return false;
                    }
                    $openIndex = array_search($lastChar, $this->opens);
                    if ($openIndex !== $closeIndex) {
                        return false;
                    }
                }
            }
        } catch (\Exception $exception) {
            return false;
        }
        return count($stack) === 0;
    }
}