<?php

ini_set('display_errors', 1);

require_once('vendor/autoload.php');

$host = 'otus.ru';
$ping = new \JJG\Ping($host);
$latency = $ping->ping();

if ($latency !== false) {
    print 'Latency is ' . $latency . ' ms';
}
else {
    print 'Host could not be reached.';
}