<?php
require_once 'vendor/autoload.php';
require_once 'Event.php';
require_once 'RedisStorage.php';

$testEvent = new Event('testEvent', 20, 'abc', 'qwe');
$testEvent1 = new Event('testEvent1', 10, 'abc', 'wsx');
$testEvent2 = new Event('testEvent2', 200, 'abc', 'qwe');
$client = new RedisStorage('tcp://redis:6379');

try {
    $client->addEvent($testEvent);
    $client->addEvent($testEvent1);
    $client->addEvent($testEvent2);
}
catch (Exception $e)
{
    echo $e->getMessage() . PHP_EOL;
}
var_dump($client->getEvent(['abc', 'qwe']));
