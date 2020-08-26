<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\App;

(new App())->startSession(__DIR__ . '/conf.ini');
