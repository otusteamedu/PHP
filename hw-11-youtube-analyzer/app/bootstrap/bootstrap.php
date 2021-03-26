<?php

use App\Log\Log;
use App\Storage\Storage;

require __DIR__ . '/../vendor/autoload.php';

Log::getInstance()->addRecord('bootstraping the app');

Storage::getInstance()->init();