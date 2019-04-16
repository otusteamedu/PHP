<?php

/**
 * Построчно валидируем STDIN на коректный email адрес
 *
 */

require '../vendor/autoload.php';

use Otus\EmailChecker;

$example = new EmailChecker;

while (($line = fgets(STDIN)) !== false) {

    $line = trim($line);
    echo sprintf('%s %s%s', ($example->checkEmail($line) ? " " : "x"), $line, PHP_EOL);

}