<?php

require_once 'vendor/autoload.php';

$arr = ['https://www.ya.ru', 'https://www.nonononono.ru'];

$Checker = new \Astrviktor\Tools\Url\UrlChecker($arr);
$statusUrls = $Checker->getStatusUrls();

print_r($statusUrls);

