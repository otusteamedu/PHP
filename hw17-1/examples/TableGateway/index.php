<?php

require_once '../../vendor/autoload.php';

use TimGa\DbPatterns\Database\Postgres;
use TimGa\DbPatterns\Model\TableGateway\Schedule;

$pdo = Postgres::connect('pgsql:host=192.168.56.101;dbname=cinema', 'timofey', 'timofey123');

$schedule = new Schedule($pdo);

// insert schedules
$lastInsertId = $schedule->insert(['movie_id' => 1, 'begin_time' => '2019-08-14 10:00:00', 'hall_id' => 1, 'price' => 200]);
$lastInsertId = $schedule->insert(['movie_id' => 1, 'begin_time' => '2019-08-14 12:00:00', 'hall_id' => 2, 'price' => 300]);
$lastInsertId = $schedule->insert(['movie_id' => 1, 'begin_time' => '2019-08-14 14:00:00', 'hall_id' => 3, 'price' => 400]);
$lastInsertId = $schedule->insert(['movie_id' => 2, 'begin_time' => '2019-08-14 16:00:00', 'hall_id' => 1, 'price' => 500]);
$lastInsertId = $schedule->insert(['movie_id' => 2, 'begin_time' => '2019-08-14 18:00:00', 'hall_id' => 2, 'price' => 600]);

// select multiple schedules by movieId
$result = $schedule->selectByMovieId(1);

// update schedule by scheduleId
$schedule->update(['schedule_id' => $lastInsertId, 'movie_id' => 4, 'begin_time' => '2019-08-10 10:00:00', 'hall_id' => 3, 'price' => 100]);

// delete schedule by last inserted scheduleId
$schedule->deleteByScheduleId($lastInsertId);
