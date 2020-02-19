<?php

namespace App\Commands;

interface Command
{
    public static function getName(): string;
    public function process(): void;
}
