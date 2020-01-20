<?php
require __DIR__ . '/vendor/autoload.php';
use shaydurov\brackets\BracketsValidator;
use shaydurov\brackets\Response;

const OK = 200;
const BAD_REQUEST = 400;
const SUCSESS_MSG = 'Your request passed validation';

$validator = new BracketsValidator();
$validator->validateLine($_POST["brackets"]);
$responce = new Response();

($validator->error) ? $responce->sendResponce(BAD_REQUEST, $validator->error) : $responce->sendResponce(OK, SUCSESS_MSG);

