<?php

namespace App\IO\Input;

interface Input
{
    public function readLn(string $prompt = null): string;
}
