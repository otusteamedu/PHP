<?php

use Routes\PreparedArgs;
use Routes\Router;

ini_set('display_errors', 'Off');
require_once __DIR__ . '/../bootstrap/init.php';
New PreparedArgs();
Router::run();

