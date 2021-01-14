<?php
require_once '../bootstrap/bootstrap.php';

use VideoPlatform\platforms\Youtube;
use VideoPlatform\VideoPlatform;

try {

    if (php_sapi_name() != 'cli') {
        throw new Exception('need to run in cli mode');
    }

    $videoPlatform = new Youtube();
    $app = new VideoPlatform($videoPlatform);
//    $app->analyze();
    $app->findById('UCGNIf8qTK5lgwp0yysGKc7g');

} catch (\Exception $e) {
    echo $e->getMessage();
}
