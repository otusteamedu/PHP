<?php

declare(strict_types=1);

namespace App\IO;

use App\Contracts\IO\Input;
use Exception;

class StdInput implements Input
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!extension_loaded('readline')) {
            throw new Exception('The readline extension is not loaded');
        }
    }
    /**
     * @inheritDoc
     */
    public function readLn(string $prompt = null): string
    {
        return trim(readline($prompt));
    }
}
