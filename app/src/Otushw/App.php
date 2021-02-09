<?php

namespace Otushw;

/**
 * Class App
 *
 * @package Otushw
 */
class App
{

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->loadConfig();
    }

    private function loadConfig(): void
    {
        $config = new Config(__DIR__ . '/../../config.yaml');
        $config->load();
    }

    public function run()
    {
        $demo = new Demo();
    }

}
