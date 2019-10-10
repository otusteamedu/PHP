<?php

require_once '../vendor/autoload.php';

use TimGa\hw26\router\Router;

define('ROOT', dirname(__DIR__));

Router::run();
