<?php

declare(strict_types=1);

namespace App\Configs;

class Config
{
    public function __construct($environment)
    {
        if ($environment == 'dev') {
            error_reporting(E_ALL);
            ini_set('display_errors', 'on');
        }
    }
}
