<?php

echo "<pre>";
$out = [
    'SERVER_ADDR'   => $_SERVER['SERVER_ADDR'],
    'REMOTE_ADDR'   => $_SERVER['REMOTE_ADDR'],
];
print_r($out);
echo "</pre>";
