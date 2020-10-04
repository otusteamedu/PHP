<?php

namespace Otus;

interface ConfigContract
{
    public function set(string $key, $value): void;

    public function get(string $key, $default = null);
}