<?php

namespace BracketsString;

/**
 * Class BracketsString
 *
 * @package BracketsString
 */
class BracketsString
{
    /**
     * @var string
     */
    public string $value;

    /**
     * BracketsString constructor.
     *
     * @param string $string
     */
    public function __construct (string $string)
    {
        $this->value = $string;
    }
}