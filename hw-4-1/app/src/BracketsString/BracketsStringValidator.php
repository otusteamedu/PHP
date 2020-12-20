<?php

namespace BracketsString;

/**
 * Class BracketsStringValidator
 *
 * @package BracketsString
 */
class BracketsStringValidator
{
    /**
     * @var BracketsString
     */
    private BracketsString $bracketsString;

    /**
     * BracketsStringValidator constructor.
     *
     * @param BracketsString $bracketsString
     */
    public function __construct(BracketsString $bracketsString)
    {
        $this->bracketsString = $bracketsString;
    }

    /**
     * Валидация и отдача header
     */
    public function validate (): void
    {
        if ($this->checkLength() === false || $this->checkBrackets() === false) {
            header('HTTP/1.1 400 Bad request');
            echo "string is not valid";
        }
        else {
            header('HTTP/1.1 200 OK');
            echo "string is OK";
        }
    }

    /**
     * Валидация на длину
     *
     * @return bool
     */
    private function checkLength (): bool
    {
        if (strlen($this->bracketsString->value) < 2) {
            return false;
        }

        return true;
    }

    /**
     * Валидация скобок
     *
     * @return bool
     */
    private function checkBrackets (): bool
    {
        if (strlen(str_replace(['(', ')'], '', $this->bracketsString->value)) > 0) {
            return false;
        }

        if ((substr($this->bracketsString->value, 0, 1) === ')') || (substr($this->bracketsString->value, -1, 1) === '(')) {
            return false;
        }

        $bracketsContainer = [];

        foreach (str_split($this->bracketsString->value) as $bracket) {
            if ($bracket === '(') {
                $bracketsContainer[] = $bracket;
                continue;
            }

            if (count($bracketsContainer) === 0) {
                return false;
            }

            array_pop($bracketsContainer);
        }

        if (!empty($bracketsContainer)) {
            return false;
        }

        return true;
    }
}