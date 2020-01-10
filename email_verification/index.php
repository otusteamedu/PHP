<?php 
require_once __DIR__ . '/docker/app/vendor/autoload.php';
use Own\EmailHelper;
$emails = explode(PHP_EOL, rtrim($_GET['emails']));
EmailHelper::emailVerify($emails);
