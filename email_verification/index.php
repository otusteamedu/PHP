<?php 
require_once __DIR__ . '/docker/app/vendor/autoload.php';
use Own\EmailHelper;
$email = $_GET['email'];
EmailHelper::emailVerify($email);
