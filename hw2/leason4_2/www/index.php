<?php
require_once('vendor/autoload.php');

try {
    $app = new App();
    $app->run();
}
catch(Exception $e){

}