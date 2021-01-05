<?php

namespace App\Api;

interface ConfigInterface
{

    public function get(string $name, $default = null);

    public function getOrFail(string $name);

}