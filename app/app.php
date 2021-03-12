<?php

// берем данные из файла настроек
require_once __DIR__ . '/../bootstrap/init.php';

try {
    $app = new app\StartSocket();
    $app->run($argv);
}
catch(Exception $exception){
    echo "Error:". $exception->getCode().". ".$exception->getMessage().PHP_EOL;
}
echo "Good bye. See you later...\n";
