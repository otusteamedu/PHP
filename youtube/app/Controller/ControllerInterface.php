<?php

namespace App\Controller;

use App\Core\ResponseInterface;

interface ControllerInterface
{
    public function execute(string $action): ?ResponseInterface;
}