<?php

namespace App\Api;

interface ControllerInterface
{
    public function execute(string $action): ViewInterface;
}