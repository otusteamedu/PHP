<?php
include_once 'vendor/autoload.php';
$arEmail = array(
    'mostovoi@bk.ru',
    'olol@yandex.ru',
    'olol@yandex',
    'olol@yand.ex',
    'ol.ol1@yand.ex',
    'ol.ol1@1yand.ex44',
    'ol.ol11yand',
    'mail.ru',
);
$app = new Tirei01\Hw6\Application($arEmail);
$app->run();