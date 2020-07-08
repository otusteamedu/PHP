<?php

use Application\Application;

require_once(__DIR__ . '/../vendor/autoload.php');

$emails = [
    'test@mail.ru',
    'test@yandex.ru',
    'test@gmail.com',
    'test@test.zzz',
    'test@testru',
    'testtestru',
];

$app = new Application();
$emailTestResults = $app->run($emails);

foreach ($emailTestResults as $email => $result) {
    echo $email . '<br>' . PHP_EOL;
    echo nl2br(trim($result)) . PHP_EOL;
    echo '<br>-----<br>' . PHP_EOL;
}

