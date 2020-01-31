<?php

use Controller\PriorityEventPageController as Controller;

$maxPriorityEvent = Controller::getEvent();
$conditions = Controller::getFilterAsString();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link type="text/css" rel="stylesheet" href="/css/style.css"/>
    <title>Priority Event</title>
</head>

<body>
<h1>Событие</h1>
<p>
    Событие, подходящее под критерии и имеющее наивысший приоритет
</p>

<div>
    Фильтр (conditions): <?= $conditions ?>
</div>

<table class="int1">
    <thead>
    <tr>
        <th>Событие</th>
        <th>Описание</th>
        <th>Критерии</th>
        <th>Приоритет</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($maxPriorityEvent->isExists()) : ?>
        <tr>
            <td><?= Controller::getEvent()->getTitle() ?></td>
            <td><?= Controller::getEvent()->getDescription() ?></td>
            <td><?= Controller::getEvent()->getConditionsAsString() ?></td>
            <td><?= Controller::getEvent()->getPriority() ?></td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>