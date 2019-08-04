<?php

require_once __DIR__ . '/../../autoload.php';

use App\Models\Analitic;


if (!empty($_POST)) {
    $priority = $_POST['priority'];
    $condition = explode(' ', $_POST['condition']);
    $event = $_POST['event'];
}

$analitic = Analitic::getInstance();


$analitic->addEvent($priority, $condition, $event);

header('Location: /App/Admin/analitic.php');