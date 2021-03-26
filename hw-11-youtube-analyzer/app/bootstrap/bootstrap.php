<?php

use App\Log\Log;

require __DIR__ . '/../vendor/autoload.php';

Log::getInstance()->addRecord('bootstraping the app');