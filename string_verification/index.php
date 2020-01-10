<?php 
require_once __DIR__ . '/docker/app/vendor/autoload.php';
use Own\StringHelper;
$string = $_GET['text'];
StringHelper::stringVerify($string);
