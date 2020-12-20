<?php

namespace App;

use Socket\SocketRunner;

/**
 * Class App
 *
 * @package App
 */
class App
{
    /**
     * @param string $mode
     */
    public function run (string $mode): void
    {
        (new SocketRunner($mode))->run();
    }
}