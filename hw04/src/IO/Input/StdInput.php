<?php

namespace App\IO\Input;

use Exception;

class StdInput implements Input
{
    public function __construct()
    {
        if (! extension_loaded('sockets')) {
            throw new Exception('The readline extension is not loaded');
        }
    }

    /**
     * @param string|null $prompt
     * @return string
     */
    public function readLn(string $prompt = null): string
    {
        return trim(readline($prompt));
    }
}
