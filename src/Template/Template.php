<?php

namespace Bjlag\Template;

interface Template
{
    public function render(string $path, array $params = []): string;
}
