<?php
require __DIR__ . '/vendor/autoload.php';

use Src\App;
use Src\Exceptions\BaseException;

try {
    $file = (isset($argv[1])) ? $argv[1] : null;
    if (empty($file)) {
        echo 'Base usage of script - run app.php {file_with_emails}' . PHP_EOL;
        exit(1);
    }
    $list = file_get_contents($file);
    $app = new App($list);
    $app->run();
} catch (BaseException $e) {
    echo $e->getMessage() . PHP_EOL;
}