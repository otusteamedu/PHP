<?php
declare(strict_types=1);

print_r('Введите команду: ');
$inputCommand = trim(fgets(STDIN));
$inputCommand = preg_replace('| +|', ' ', $inputCommand);
$originalCommand = "git commit";

if ($inputCommand === $originalCommand) {
    print_r("Ошибок не обнаружено." . PHP_EOL);
} else {
    print_r("Вы имели ввиду команду $originalCommand" . PHP_EOL);
}

print_r("Вы хотите выполнить команду $originalCommand? (y/n)" . PHP_EOL);
if (trim(fgets(STDIN)) == 'y') {
    print_r(shell_exec($originalCommand));
} else {
    print_r('Команда не выполнена.' . PHP_EOL);
}
