<?php

namespace App\Commands;

interface Command
{
    public function getName(): string;
    public function process(): void;
}
