<?php
require "../vendor/autoload.php"; 
use Application\App;

try {
    $app = new App();
    $app->run();
}

catch(Exception $e){
    echo 'Ошибка: ',  $e->getMessage(), "\n";
}

