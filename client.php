<?php

require_once(__DIR__ . '/vendor/autoload.php');

use nvggit\hw26\models\Task;
use nvggit\hw26\rabbit\RabbitClient;

$clientTask = new RabbitClient(Task::TYPE_FROG_HARD_WORK);

$task = new Task();
$task->status = Task::STATUS_NEW;
$task->type = Task::TYPE_FROG_HARD_WORK;

$clientTask->addTask($task);

$clientListener = new RabbitClient(Task::TYPE_FROG_HARD_WORK_STATUS);
$clientListener->listen();