<?php
require_once __DIR__ . "/BracketsHelper.php";
if (isset($_REQUEST['string'])) {
    $str = filter_input(INPUT_POST, 'string', FILTER_SANITIZE_STRING);
    if (models\BracketsHelper::checkIsValid($str)) {
        header("HTTP/1.1 200 Valid brackets");
        echo "brackets are valid";
    } else {
        header("HTTP/1.1 400 Bad string sent");
        echo "brackets are not valid";
    }
} else {
    header("HTTP/1.1 400 String required");
    echo "no string entered";
}
exit;