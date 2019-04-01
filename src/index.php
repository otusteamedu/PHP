<?php

function badRequest()
{
    header('HTTP/1.1 400 Bad Request');
    exit('error');
}

function checkBrackets(string $input): bool
{
    $brackets = [')' => '('];

    $stack = [];
    for ( $i = 0, $size = strlen($input); $i < $size; $i++ ) {
        $char = $input{$i};

        if ( !isset($brackets[$char]) ) {
            $stack[] = $char;
            continue;
        }

        $el = array_pop($stack);
        if ( $el !== $brackets[$char] ) {
            return false;
        }
    }

    return $stack ? false : true;
}


if($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['string']) || !checkBrackets($_POST['string']))
{
   badRequest();
}

header('HTTP/1.1 200 OK');
exit('ok');
