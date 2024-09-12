<?php

/**
 * Проверка валидности массива email-ов тестовым post-запросом
 */

require_once __DIR__ . "/vendor/autoload.php";


$emails = ['test@asd', 'test@mail.ru', 'test@host.asr'];
echo \HW\Client::send($emails);