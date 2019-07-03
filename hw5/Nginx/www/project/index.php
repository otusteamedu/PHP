<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit("Метод не POST");
}
foreach ($_POST as $key => $value) {
    if ($key === 'string') {
        if (strlen("$key=$value") == $_SERVER['CONTENT_LENGTH'] && isCorrect($_POST['string'])) {
            header("HTTP/1.0 200 OK");
            echo "OK" . PHP_EOL;
        } else {
            header("400 Bad Request");
            exit("Bad Request" . PHP_EOL);
        }
    }
}


function isCorrect(string $string): bool 
{
    $stringLength = strlen($string);
    $stack = [];
    for ($i = 0; $i < $stringLength; $i++) {
        $symbol = $string[$i];
        if ($symbol == '(') {
            $stack[] = $symbol;
        } elseif ($symbol == ')') {
            if (!$lastStackSymbol = array_pop($stack)) {
                return false;
            }
            if ($symbol == ')' && $lastStackSymbol != '(') {
                return false;
            }
        }
    }
    return count($stack) === 0;
}
