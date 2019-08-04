<?php
require_once __DIR__ . '/autoload.php';
/**
 * @var $event \App\Models\Event
 */

use App\Models\DBRedis;
use App\Models\Event;


$events = DBRedis::getAll();


$str = '';
$priority = PHP_INT_MIN;
$params = $_GET;
$flag = false;
foreach ($events as $event) {
    $conditions = $event->getConditions();
    $count = 0;
    foreach ($params as $param) {
        if ($conditions[$count++] == $param) {
            $flag = true;
        } else {
            $flag = false;

        }
    }
    if ($flag == true) {
        if ($event->getPriority() > $priority) {
            $priority = $event->getPriority();
            $str = $event->getEvent();
        }
    }
}

echo $str;