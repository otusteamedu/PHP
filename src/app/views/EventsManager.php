<?php

use Controller\EventsManagerPageController as Controller;
use Filter\EventsFilter;

$eventsList = Controller::getEventsList();
$eventConditionPrefix = Controller::getEventConditionPrefix();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link type="text/css" rel="stylesheet" href="/css/style.css"/>
    <title>Events Manager</title>
</head>
<body>
<h1>Events Manager</h1>

<section class="int15 event_manager" style="display: none">
    <h3>Добавление события</h3>
    <form target="_blank" action="/events" method="post">
        <label>
            <input type="text" name="<?= EventsFilter::TITLE ?>" placeholder="Название события" required="required"/>
        </label>
        <label>
            <input type="text" name="<?= EventsFilter::DESCRIPTION ?>" placeholder="Описание события" required="required"/>
        </label>
        <label>
            <input name="<?= EventsFilter::PRIORITY ?>" type="number" placeholder="Приоритет" required="required" style="width: 84px"/>
        </label>
        <div class="int1">
            <h4>Критерии события</h4>
            <em>(для добавления критерия нажмите +, для удаления -)</em>
            <div class="event_conditions_container">
            </div>
            <div class="int05">
                <input type="button" value=" + " class="add_condition"/>
            </div>
        </div>
        <div class="int1">
            <input type="submit" value="Создать событие"/>
        </div>
    </form>
</section>

<section class="int1 event_manager" style="display: none">
    <form action="javascript:void(0);" method="get" class="event_manager" id="filter_events_form" target="_blank">
        <h3>Фильтр событий</h3>
        <h4>Критерии события</h4>
        <input type="button" value="+" class="add_condition_filter" title="Добавить параметр"/>
        <div class="int1">
            <h4>Применить фильтр</h4>
            <input type="submit" value="Получить HTML" class="filter_html"/>
            <input type="submit" value="Получить JSON" class="filter_json"/>
        </div>
        <div class="int05">
            <h4>Показать приоритетное событие</h4>
            <input type="submit" value="Получить HTML" class="priority_as_html"/>
            <input type="submit" value="Получить JSON" class="priority_as_json"/>
        </div>
    </form>
    <div class="int2">
        <label><a href="/events/manager">Все события</a></label>
    </div>
</section>

<h3>События</h3>
<label><a href="/events/delete">Удалить события</a></label>
<table class="int15">
    <thead>
    <tr>
        <th>#</th>
        <th>Событие</th>
        <th>Описание</th>
        <th>Критерии</th>
        <th>Приоритет</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($eventsList as $i => $event) {
        ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $event->getTitle() ?></td>
            <td><?= $event->getDescription() ?></td>
            <td><?= $event->getConditionsAsString() ?></td>
            <td><?= $event->getPriority() ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<div id="filter_condition_template" style="display: none">
    <label class="nowrap">
        <span class="condition_label"></span>
        <input type="text" maxlength="1" class="condition_input" style="width: 2em"/>
        <input type="button" value="-" class="delete_condition_filter" title="Удалить параметр"/>
    </label>
</div>

<div id="event_condition_template" style="display: none">
    <span class="event_condition nowrap">
        <label>
            <span class="condition_label"></span>
            <input type="text" maxlength="1" class="condition_input" style="width: 2em"/>
        </label>
        <input type="button" value=" - " class="delete_condition"/>
    </span>
</div>

<input id="conditionPrefix" value="<?= $eventConditionPrefix ?>" type="hidden"/>
<input id="filtered_as_html_url" value="" type="hidden"/>
<input id="filtered_as_json_url" value="/events/get" type="hidden"/>
<input id="priority_as_html_url" value="/events/priority_html" type="hidden"/>
<input id="priority_as_json_url" value="/events/priority" type="hidden"/>

<script src="/js/jquery.min.js"></script>
<script src="/js/event-manager.controller.js"></script>

</body>
</html>