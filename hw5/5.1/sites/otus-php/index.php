<?php

require_once('src/Config.php');
require_once('src/ValidatorException.php');
require_once('src/Validator.php');
require_once('src/BracketsLevel.php');
require_once('src/BracketsLevelMap.php');

use App\Validators\Validator;
use App\Configs\Config;

try {

    $config = new Config('dev');
    $requestString = isset($_REQUEST['string']) ? trim($_REQUEST['string']) : '' ;
    $validator = new Validator();
    $validator->validateLength($requestString);
    $validator->validateBrackets($requestString);

    $responseMsg = 'Скобки корректны';
    http_response_code(200);

    echo $responseMsg;

} catch (\Throwable $e) {

    http_response_code(400);

    echo "{$e->getMessage()}";
}

