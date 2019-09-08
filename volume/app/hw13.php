<?php

use ActiveRecord\SQLBuilder;

require_once __DIR__ . '/conf.php';

use hw13\models\FillDatabase;
use hw13\models\Movie;

if($argv[1] === 'migrate') {
    FillDatabase::migrate();
} elseif ($argv[1] === 'clear') {
    FillDatabase::deleteAllMovies();
} elseif ($argc === 3 && $argv[1] === 'add') {
    (new FillDatabase((int) $argv[2]))->fill();
} elseif ($argv[1] === 'auto') {
    FillDatabase::migrate();
    FillDatabase::deleteAllMovies();
    (new FillDatabase(10000000))->fill();
}
