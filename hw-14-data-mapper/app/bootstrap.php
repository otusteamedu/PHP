<?php

use App\Config\Config;
use App\Log\Log;

require __DIR__ . '/vendor/autoload.php';

Config::getInstance()->setConfig('../config.yml');

Log::getInstance()->addRecord('bootstraping the app');