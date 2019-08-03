#!/usr/local/bin/php
<?php
require('../vendor/autoload.php');
require('../config/config.php');

use Paa\Models\RabbitModel;
use Paa\Models\PostgresqlModel;

$rabbit = new RabbitModel();
$db = new PostgresqlModel();

while($i=1) {
    $msgText = $rabbit->receiveMess();
    $db->insertMess($msgText);

    echo 'Received: '. $msgText . PHP_EOL;
}
die;            