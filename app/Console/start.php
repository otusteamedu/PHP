<?php
use App\Console\Routes\ConsoleRouter;
use App\Http\Response\ResponseCli;

require_once __DIR__ . '/../../bootstrap/init.php';

try {
    ConsoleRouter::run($argv);
}
catch(Exception $ex){
    (new ResponseCli())->send($ex->getCode(), $ex->getMessage());
}