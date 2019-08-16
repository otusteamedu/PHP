<?php

require_once '../../vendor/autoload.php';

use TimGa\DbPatterns\Database\Postgres;
use TimGa\DbPatterns\Model\DataMapper\ScheduleMapper;

$pdo = Postgres::connect('pgsql:host=192.168.56.101;dbname=cinema', 'timofey', 'timofey123');

$scheduleMapper = new ScheduleMapper($pdo);

// insert
$schedule1 = $scheduleMapper->insert(['movie_id'=>1, 'begin_time'=>'2019-08-14 10:00:00', 'hall_id'=>1, 'price'=>100]);
$schedule2 = $scheduleMapper->insert(['movie_id'=>2, 'begin_time'=>'2019-08-14 10:00:00', 'hall_id'=>2, 'price'=>200]);
$schedule3 = $scheduleMapper->insert(['movie_id'=>3, 'begin_time'=>'2019-08-14 10:00:00', 'hall_id'=>3, 'price'=>300]);

// delete schedule #1
$scheduleMapper->delete($schedule1);

// update schedule #2
$schedule2->setPrice(1000);
$scheduleMapper->update($schedule2);