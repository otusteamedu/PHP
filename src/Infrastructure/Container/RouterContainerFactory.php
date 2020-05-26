<?php

namespace Infrastructure\Container;

class RouterContainerFactory
{
    public function __invoke()
    {
        return (require 'config/routes.php')();
    }
}
