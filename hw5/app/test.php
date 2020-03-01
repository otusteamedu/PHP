<?php

/**
 * Проверка валидности строки тестовым post-запросом
 */

require_once __DIR__ . "/vendor/autoload.php";


$string = "((()()()()))((((()()()))(()()()(((()))))))";
echo \HW\Client::send($string);