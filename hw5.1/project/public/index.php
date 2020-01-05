<?php
require __DIR__.'/../vendor/autoload.php';

use AI\backend_php_hw5_1\Exceptions\MyException;
use AI\backend_php_hw5_1\Http\RequestHandler;
use AI\backend_php_hw5_1\Http\Response;
use AI\backend_php_hw5_1\Validators\BracketSequenceValidator;

$requestHandler = new RequestHandler();
$response = new Response();
$bracketValidator = new BracketSequenceValidator();

try {
    $requestHandler->proceed($_POST, $bracketValidator);
    $response->send(Response::OK, 'Корректная строка');
} catch (MyException $exception) {
    $response->send(Response::BAD_REQUEST, $exception->getMessage());
}
