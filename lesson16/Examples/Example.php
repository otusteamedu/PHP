#!/usr/bin/env php

<?php

// define APP_DIR location
// APP_DIR . '/config.ini keep your youtube token and base api url
define('APP_DIR', __DIR__ . '/..' );
require APP_DIR . '/vendor/autoload.php';

use Otus\{Grabber, Informer, BaseRecord};

// Configure connection to MongoDB
BaseRecord::$connection = new MongoDB\Client();
BaseRecord::$database = 'myapp';

try {
    $grabber = new Grabber();
    echo 'Grab channel UCigmJGP6E-wbZGclCDkalcQ' . PHP_EOL;
    $grabber->grabChannel('UCigmJGP6E-wbZGclCDkalcQ');

    echo 'Grab channel UCBJ8lINWy72UTid23846n_A' . PHP_EOL;
    $grabber->grabChannel('UCBJ8lINWy72UTid23846n_A');

    echo 'Grab channel UCS9cAcNWZfcsQX_CbxUuyYQ' . PHP_EOL;
    $grabber->grabChannel('UCS9cAcNWZfcsQX_CbxUuyYQ');

    echo 'Rate channels by likes/dislikes' . PHP_EOL;
    $rate = Informer::getTopChannelsByValue(2);
    foreach ($rate as $channel) {
        echo '_id: ' . $channel->getID() . ', ' . $channel->getTitle() . ', rate: ' . $channel->getRates() . PHP_EOL;
    }
    echo 'Rate channels by dislikes' . PHP_EOL;
    $rate = Informer::getTopChannelsByValue(2, 'dislikes');
    foreach ($rate as $channel) {
        echo '_id: ' . $channel->getID() . ', ' . $channel->getTitle() . ', dislikes: ' . $channel->getDislikes() . PHP_EOL;
    }
    echo 'Rate channels by videos' . PHP_EOL;
    $rate = Informer::getTopChannelsByValue(2, 'videos');
    foreach ($rate as $channel) {
        echo '_id: ' . $channel->getID() . ', ' . $channel->getTitle() . ', videos: ' . $channel->getVideos() . PHP_EOL;
    }
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}


