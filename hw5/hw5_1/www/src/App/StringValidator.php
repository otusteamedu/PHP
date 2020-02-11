<?php

namespace App;

class StringValidator
{
    private const REG_BRACKETS = '/^[^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)++$/';
    protected $string;

    /**
    * @param string $string
    */
    public function __construct(string $string)
    {
        $this->string = $string;
    }


    public function validate(): bool
    {
        return preg_match(self::REG_BRACKETS, $this->string, $matches) === 1;
    }
}