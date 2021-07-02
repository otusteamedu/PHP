<?php

namespace App\Core;

interface ConfigInterface
{

    public function get(string $name, $default = null);

    public function getOrFail(string $name);

}