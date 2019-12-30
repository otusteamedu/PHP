<?php
// app/Support/ServiceProviderInterface.php

namespace App\Support;

use UltraLite\Container\Container;

interface ServiceProviderInterface
{

    public function register(Container $container);
}