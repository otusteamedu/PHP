<?php

$expectedString = 'commit';

while ($line = trim(fgets(STDIN))) {

    if (count(explode(' ', $line)) > 1) {
        $currentString = explode(' ', $line)[1];
    } else {
        echo "Я не знаю, что вы хотели\n";
    }

    $levenshtein = levenshtein($currentString, $expectedString);

    if ($levenshtein < 5) {
        if ($levenshtein == 0) {
            echo "Вы ввели команду commit верно\n";
        } else {
            echo "Наверное вы имели ввиду commit\n";
        }
    } else {
        echo "Я не знаю, что вы хотели\n";
    }
}