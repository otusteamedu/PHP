<?php

require_once(__DIR__ . '/vendor/autoload.php');

use nvggit\hw26\QueueApi;

try {
    $api = new QueueApi();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}