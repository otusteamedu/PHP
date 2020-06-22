<?php

namespace HomeWork\Factory;

use HomeWork\Entity\ConfigInterface;

interface ConfigFactoryInterface
{
    public function create(): ConfigInterface;
}
