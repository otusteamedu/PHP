<?php
require_once __DIR__ . "/vendor/autoload.php";

use models\BracketsHelper;
use models\ResponseHelper;

$str = isset($_POST) ? filter_input(INPUT_POST, 'string', FILTER_SANITIZE_STRING) : null;

if (!is_null($str) && strlen($str) > 0) {
    if (BracketsHelper::checkIsValid($str))
        ResponseHelper::sendOk("Brackets are valid");
    else
        ResponseHelper::sendError("brackets are not valid");
} else
    ResponseHelper::sendError("no or empty string entered");

exit;