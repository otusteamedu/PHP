<?php
require 'vendor/autoload.php';

$amo = new \AmoCRM\Client('admiraltest', 'whitecomp777@yandex.ru', 'a72f746a1be8a8ec25b013908ae7ab1d03dbdc6d');
$leads = $amo->lead->apiList([]);

//В аккаунте 4 лида
assert(count($leads) == 4);

//Показывает список сделок
foreach ($leads as $lead) {
    echo sprintf("Сделка #%s %s", $lead['id'], $lead['name']) . PHP_EOL;
}
