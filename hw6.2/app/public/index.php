<?php
echo "<pre>";
$out = [
    'SERVER_NAME'   => $_SERVER['SERVER_NAME'],
    'SERVER_ADDR'   => $_SERVER['SERVER_ADDR'],
    'HOSTNAME'      => $_SERVER['HOSTNAME'],
    'REMOTE_ADDR'   => $_SERVER['REMOTE_ADDR'],
];
print_r($out);
echo "</pre>";
