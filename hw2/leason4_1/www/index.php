<?php

const minLength = 20;

function sendError($msg)
{
    header('HTTP/1.1 400 Bad Request');
    echo "<h1>$msg</h1>";
    exit(1);
}

/**
 * Проверка скобочной последовательности
 *
 * @param string $s проверяемая строка
 *
 * @return bool
 * @see https://neerc.ifmo.ru/wiki/index.php?title=Правильные_скобочные_последовательности
 */
function check($s)
{
    $c   = 0;
    $len = strlen($s);
    for ($i = 0; $i < $len; $i++) {
        if ($s[$i] == '(') {
            $c++;
        } else {
            $c--;
        }
        if ($c < 0) return false;
    }

    return $c == 0;
}

$data = $_POST['string'];
if (empty($data)) {
    sendError("Необходимо отправить POST-запрос");
}

$len = strlen($data);
if ($len < minLength) {
    sendError('Слишком короткая (' . $len . ') последовательность. Минимум ' . minLength . ' символов');
}

if (check($data)) {
    echo "Все хорошо!";
    exit(0);
} else {
    sendError('Последовательность скобок не верная');
}
