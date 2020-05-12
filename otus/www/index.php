<?php


use Classes\BracketBalanceCheckServiceImpl;
use Classes\BracketCheckRequest;
use Classes\BracketCheckRequestBuilder;
use Classes\BracketStringValidator;
use Classes\BracketStringValidatorImpl;
use Classes\Predicates\PredicateServiceImpl;

require_once 'vendor/autoload.php';

//$_POST['string'] = '[[]]{{}}((';

$bracketCheckRequestBuilder = new BracketCheckRequestBuilder();
/** @var BracketCheckRequest $bracketCheckRequest */
$bracketCheckRequest = $bracketCheckRequestBuilder
    ->setString($_POST)
    ->build();

/** @var BracketStringValidator $bracketStringValidator */
$bracketStringValidator = new BracketStringValidatorImpl(new PredicateServiceImpl(), $bracketCheckRequest);

$bracketBalanceCheckService = new BracketBalanceCheckServiceImpl($bracketStringValidator);
$bracketCheckResponse = $bracketBalanceCheckService->run();

$response = [
    'responseMessage' => $bracketCheckResponse->responseMessage,
    'errors' => $bracketCheckResponse->bracketCheckErrors
];

header(sprintf('HTTP/1.1 %s', $bracketCheckResponse->status));
header('Content-type: application/json');
echo json_encode($response);
