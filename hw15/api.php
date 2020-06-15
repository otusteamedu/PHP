<?php

require_once "vendor/autoload.php";

$api = new \App\Api\Api();
$result = $api->run();

echo $result;
