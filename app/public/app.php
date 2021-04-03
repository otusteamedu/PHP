<?php
require "../vendor/autoload.php"; 
use Application\App;

$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

try 
{
    $app = new App();
    $app->run();
}
catch(Exception $e)
{
    
}

