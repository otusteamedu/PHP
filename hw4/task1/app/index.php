<?php
require_once "vendor/autoload.php";

$checker = new Jekys\Brackets('string');
$response = $checker->getResponse();

http_response_code($response['code']);
echo $response['msg'];
