<?php
$response = [
    'code' => 400,
    'msg' => 'Something wrong =('
];

function checkBrackets(String $str)
{
    while (substr_count($str, '()')) {
        $str = str_replace('()', '', $str);
    }

    return strlen($str) == 0;
}

$contentLength = $_SERVER['HTTP_CONTENT_LENGTH'] - strlen('string=');

if (!empty($_POST['string']) && $contentLength == strlen($_POST['string']) && checkBrackets($_POST['string'])) {
    $response['code'] = 200;
    $response['msg'] = 'Everything is ok';
}

http_response_code($response['code']);
echo $response['msg'];
