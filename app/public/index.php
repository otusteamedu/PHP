<?php
require_once '../bootstrap/bootstrap.php';

use VideoPlatform\services\YoutubeService;
use VideoPlatform\VideoPlatform;

try {
    if (php_sapi_name() != 'cli') {
        throw new Exception('need to run in cli mode');
    }

    $videoPlatform = new YoutubeService();
    $app = new VideoPlatform($videoPlatform);
    $app->run();

} catch (\Exception $e) {
    echo $e->getMessage();
}
