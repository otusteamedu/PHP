<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('POST' === $_SERVER['REQUEST_METHOD'] && '/' === $path) {

    if (isset($_POST['string'])) {
        $data = $_POST['string'];

        $message = checkValue($data);
    } else {
        $data = file_get_contents('php://input');

        $message = checkStringParam($data);
    }

    if ($message !== 'All good') {
        header('Bad request', true, 400);
    }
    echo $message;
    exit(0);
}

phpinfo();
xdebug_info();


function checkStringParam($entityBody): string
{
    $msg = 'All bad' . PHP_EOL;

    if (!preg_match('/^string=[()]+$/', $entityBody)) {
        return $msg . 'Wrong format';
    }

    $str = explode('=', $entityBody)[1];

    return checkValue($str);
}

function checkValue($str): string
{
    $msg = 'All bad' . PHP_EOL;

    $length = strlen($str);

    if (0 === $length) {
        return $msg . 'Length = 0';
    }

    $opened = $closed = 0;

    for ($i = 0; $i < $length; $i++) {
        if ('(' === $str[$i]) {
            $opened++;
        } elseif (')' === $str[$i]) {
            $closed++;
        }
    }

    if ($opened !== $closed) {
        return $msg . 'Opened !== closed';
    }

    return 'All good';
}

