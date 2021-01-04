<?php

require_once('../vendor/autoload.php');

use ClientServer\ClientServer;

try {
    $app = new ClientServer();
    $app->run();
}
catch(Exception $e){
    echo $e->getMessage() . PHP_EOL . "\n";
}
?>