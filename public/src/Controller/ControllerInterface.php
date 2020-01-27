<?php

namespace Socket\Ruvik\Controller;

use Socket\Ruvik\DTO\InputArgs;

interface ControllerInterface
{
    public function run(InputArgs $inputArgs): void;
}
