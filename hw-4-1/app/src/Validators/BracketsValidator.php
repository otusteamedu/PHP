<?php

namespace Validators;

class BracketsValidator
{
    /**
     * @var string
     */
    private string $_string;

    /**
     * BracketsValidator constructor.
     *
     * @param string $string
     */
    public function __construct (string $string)
    {
        $this->_string = trim($string);
    }

    /**
     * Валидация и отдача header
     */
    public function validate (): void
    {
        if ($this->_checkLength() === false || $this->_checkBrackets() === false) {
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
    private function _checkLength (): bool
    {
        if (strlen($this->_string) < 2) {
            return false;
        }

        return true;
    }

    /**
     * Валидация скобок
     *
     * @return bool
     */
    private function _checkBrackets (): bool
    {
        if (strlen(str_replace(['(', ')'], '', $this->_string)) > 0) {
            return false;
        }

        if ((substr($this->_string, 0, 1) === ')') || (substr($this->_string, -1, 1) === '(')) {
            return false;
        }

        $bracketsContainer = [];

        foreach (str_split($this->_string) as $bracket) {
            if ($bracket === '(') {
                $bracketsContainer[] = $bracket;
                continue;
            }

            if (count($bracketsContainer) === 0) {
                return false;
            }

            array_pop($bracketsContainer);
        }

        return true;
    }
}