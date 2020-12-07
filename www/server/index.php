<?php

use Symfony\Component\Dotenv\Dotenv;
use Controllers\RuntimeServer;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', '../server');

include_once('..' . DS . 'server' . DS . 'vendor' . DS . 'autoload.php');
(new Dotenv())->load('..' . DS . 'server' . DS . '.env');

($loop = new RuntimeServer())
    ->startLoop();







