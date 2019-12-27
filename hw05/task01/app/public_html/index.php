<?
require 'autoload.php';

try{
    // проверка что параметр передан
    if (!isset($_POST['string'])) {
        throw new \UnexpectedValueException('POST параметр string не передан');

    }

    // проверка что передана не пустая строка (строку состоящую только из пробелов считаем пустой)
    $string = trim($_POST['string']);
    if (empty($string)) {
        throw new \UnexpectedValueException('POST параметр string не должен быть пустой строкой или строкой состоящей из пробелов');
    }

} catch (\Exception $e){
    \App\Response::sendFail($e->getMessage());
}

// Проверка скобок на парность
try{
    $chkResult = \App\BracketsChk::run($string);
    if ($chkResult) {
        \App\Response::sendOk('Проверка пройдена успешно');
    } else {
        \App\Response::sendFail('Парность скобок не корректа');
    }
} catch (\InvalidArgumentException $e){
    \App\Response::sendFail($e->getMessage());
}