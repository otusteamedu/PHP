<?php

namespace Core;

class Application
{
    public function run()
    {
        
    }

    protected function init()
    {
        ValidatorLoader::load();
    }
}