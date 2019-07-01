<?php
declare(strict_types=1);

echo 'Введите команду: ';
$userInput = trim(fgets(STDIN));
$correctCommand = 'git commit';
$shortestDistance = -1;
$distance = levenshtein($userInput, $correctCommand);
if ($distance == 0) {
    $closestMatch = $correctCommand;
    $shortestDistance = 0;
}

if ($distance <= $shortestDistance || $shortestDistance < 0) {
    $closestMatch = $correctCommand;
    $shortestDistance = $distance;
}

echo "Введено: $userInput" . PHP_EOL;
if ($shortestDistance == 0) {
    echo "Ошибок не обнаружено." . PHP_EOL;
} else {
    echo "Скорее всег вы имели ввиду $closestMatch?" . PHP_EOL;
}
echo "Выполнить команду $closestMatch? (y/n)" . PHP_EOL;
if (trim(fgets(STDIN)) == 'y') {
    echo shell_exec($closestMatch);
} else {
    echo 'Команда не выполнена, работа завершена' . PHP_EOL;
}
