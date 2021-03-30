<?php

namespace App;

use App\Router\Router;

class App
{
    public const GRAB_CMD  = 'grab';
    public const STATS_CMD = 'stats';

    /**
     * run the app
     */
    public function run (): string
    {
        $cmd = $_SERVER['argv'][1] ?? '';

        return Router::dispatch($cmd);
    }
}