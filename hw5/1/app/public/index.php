<?php

use BracketValidator\BracketValidator;
use BracketValidator\ErrorPrinter;
use BracketValidator\FormPrinter;
use BracketValidator\Validator\Even;
use BracketValidator\Validator\Length;
use BracketValidator\Validator\Pairs;
use BracketValidator\Validator\UnwantedSymbol;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once(__DIR__ . '/../vendor/autoload.php');

const FORM_PARAM_NAME = 'form';
const PARAM_NAME = 'string';

$request = new Request(
    $_GET,
    $_POST,
);

if ($request->query->has(FORM_PARAM_NAME)) {
    FormPrinter::print(PARAM_NAME);
    exit;
}

$errors = (new BracketValidator)
    ->addValidator(new Length)
    ->addValidator(new UnwantedSymbol)
    ->addValidator(new Even)
    ->addValidator(new Pairs)
    ->run($request->request->get(PARAM_NAME));

$responseContent = 'Ok';
$responseCode = Response::HTTP_OK;

if (!empty($errors)) {
    $responseContent = ErrorPrinter::getFormattedErrors($errors, "# %s<br>");
    $responseCode = Response::HTTP_BAD_REQUEST;
}

(new Response($responseContent, $responseCode))->send();





