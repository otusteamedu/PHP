<?php

namespace Otus\Config;

interface ConfigContract
{
    public function set(string $key, $value): self;

    public function get(string $key, $default = null);
}
