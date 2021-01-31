<?php

namespace Otushw;

use Exception;

class App
{
    public function run(): void
    {
        $app = AppFactory::create();
        $app->execute();
    }

}