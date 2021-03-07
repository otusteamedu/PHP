<?php
require_once ('vendor/autoload.php');

use Src\App;

try {
    $app = new App($_POST['string']);
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}