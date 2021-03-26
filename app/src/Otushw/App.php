<?php

namespace Otushw;

class App
{

    private AppInstanceAbstract $appInstance;

    public function __construct()
    {
        $this->loadConfig();
        $app = new AppFactory();
        $this->appInstance = $app->create();
    }

    private function loadConfig(): void
    {
        Config::create();
    }

    public function run()
    {
        $this->appInstance->run();
    }
}

