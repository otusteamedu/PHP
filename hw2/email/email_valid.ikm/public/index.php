<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 04.01.21
 * Time: 20:52
 */

require_once('../vendor/autoload.php');

use EmailValid\EmailValid;

try {
    $valid = new EmailValid();
    $valid->review($_REQUEST['arr_email']);
}
catch(Exception $e){
    echo $e->getMessage() . PHP_EOL . "\n";
}
?>