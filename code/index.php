<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap/bootstrap.php';

use Src\App;

try {
    $app = new App($_POST, $argv);
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
