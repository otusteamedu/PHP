<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/conf.php';

use hw13\models\FillDatabase;

$fill = new FillDatabase(5);
$fill->execute();