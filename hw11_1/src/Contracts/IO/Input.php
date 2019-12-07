<?php

declare(strict_types=1);

namespace App\Contracts\IO;

interface Input
{
    /**
     * @param string|null $prompt
     * @return string
     */
    public function readLn(string $prompt = null): string;
}
