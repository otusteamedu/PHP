<?php

require_once "vendor/autoload.php";

try {
    $http = new \LineProcessing\LineProcessing();
    $http->run();
} catch (Exception $e) {
    echo $e->getMessage();
}

