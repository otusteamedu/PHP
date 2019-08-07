<?php


require_once __DIR__ . '/Statistic.php';

$static = new Statistic();


$objects = $static->getViews();

include __DIR__ . "/view.php";





