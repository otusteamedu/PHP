<?php

namespace lexerom\Commands;

interface ValidCmdInterface
{
    public function getValidCommandWithArgs(): string;
    public function getValidCommand(?string $args = null): string;
}