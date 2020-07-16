<?php

namespace App\Interfaces;

interface ContainerInterface
{
    public function get(string $key);

    public function has(string $key);

}