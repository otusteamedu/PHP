#!/usr/bin/env php

<?php

// define APP_DIR location
// APP_DIR . '/config.ini keep your youtube token and base api url
define('APP_DIR', __DIR__ . '/..' );
require APP_DIR . '/vendor/autoload.php';

$lockPath = APP_DIR . '/' . basename(__FILE__ . '.lock');
if (file_exists($lockPath)) {
    echo 'Скрипт ещё работает' . PHP_EOL;
    exit;
} else {
    try {
        $f = fopen($lockPath, 'w');
        fwrite($f, date('Y-m-d H:i:s'));
        fclose($f);
    } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
        die();
    }
}
use Otus\{Grabber, BaseRecord};

try {
    // Configure connection to MongoDB
    BaseRecord::$connection = new MongoDB\Client();
    BaseRecord::$database = 'myapp';

    $grabber = new Grabber();
    $channelId = $grabber->getRandomChannelId();
    //it can take a lot of time if channel has a lot of videos
    $grabber->grabChannel($channelId);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
} finally {
    @unlink($lockPath);
}

