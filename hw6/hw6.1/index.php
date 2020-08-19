<?php

use Email\EmailList;

require_once "vendor/autoload.php";

try {
    $emailList = new EmailList();
    $emailList->validateListEmail();
    echo "Ваш запрос обработан.";
} catch (Exception $e) {
    echo $e->getMessage();
}
