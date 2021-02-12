<?php

namespace Otushw;

class App
{

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
