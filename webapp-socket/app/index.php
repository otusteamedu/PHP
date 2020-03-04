<?php 

    require_once 'vendor/autoload.php';

    if (!isset($_POST['string']))
    {
        http_response_code(400);
        echo 'Строка не получена';
        return;
    }

    if (!isset($_SERVER['HTTP_CONTENT_LENGTH']))
    {
        http_response_code(400);
        echo 'HTTP_CONTENT_LENGTH не указана';
        return;
    }

    if (!is_numeric($_SERVER['HTTP_CONTENT_LENGTH']))
    {
        http_response_code(400);
        echo 'HTTP_CONTENT_LENGTH не число';
        return;
    }

    // проверка
    $checker = new \Astrviktor\Tools\Checker\Checker();
    
    $str = 'string=' . $_POST['string'];
    $len = $_SERVER['HTTP_CONTENT_LENGTH'];

    $res = $checker->checkParenthesis($len, $str);

    http_response_code($res['answer']);
    echo $res['info'];