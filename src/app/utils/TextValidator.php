<?php

namespace Utils;

use Exception;

class TextValidator
{
    private $text = "";

    private $rules;

    public function __construct(string $text, ValidatorRules $rules)
    {
        $this->text = $text;
        $this->rules = $rules;
    }

    /**
     * @throws Exception
     */
    public function validateLength()
    {
        if (empty(trim($this->text)) && $this->rules->nonEmpty)  {
            throw new Exception("non empty string is required");
        };
    }

    /**
     * @throws Exception
     */
    public function validateBrackets()
    {
        $pattern = $this->rules->bracketsOpen . $this->rules->bracketsClose;
        $str = preg_replace('/[^' . $pattern . ']/', "", $this->text);
        $bracketsStack = array_fill(0, strlen($this->rules->bracketsOpen), 0);
        $row = array_filter(str_split($str, 1), function ($s) {
            return !empty($s);
        });
        foreach ($row as $s) {
            if (($pos = strpos($this->rules->bracketsOpen, $s)) !== false) {
                $bracketsStack[$pos]++;
            } elseif (($pos = strpos($this->rules->bracketsClose, $s)) !== false) {
                if (--$bracketsStack[$pos] < 0) {
                    throw new Exception("incorrect brackets");
                }
            }
        }
        if (!!array_sum($bracketsStack)) {
            throw new Exception("incorrect brackets");
        }
    }
}