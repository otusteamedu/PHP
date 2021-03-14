<?php

require_once('../vendor/autoload.php');

use WorkloadPhpFpm\WorkloadPhpFpm;

try {
    $valid = new WorkloadPhpFpm();
    $valid->review($_REQUEST['count_users']);
}
catch(Exception $e){
    echo $e->getMessage() . PHP_EOL . "\n";
}

?>