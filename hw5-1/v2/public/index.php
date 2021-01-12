<?php

use RoistatToActiveCampaign\App;

require '../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
}
catch(Throwable $e) {
    print_r($e->getMessage());
}