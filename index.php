<?php

$fp = fopen('input.json', 'rb+');
$json_str = '';
$arr = [];
if ($fp) {
    while(!feof($fp)) {
        $json_str .= fread($fp, 1024);
    }

    if (!empty($json_str)) {
        $arr = json_decode($json_str, true);
    }
    fclose($fp);
}

var_dump($arr);
