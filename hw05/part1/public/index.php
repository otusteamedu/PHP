<?php

use App\Validator\Validator;
use Zend\Diactoros\{Response, ServerRequestFactory};

chdir(dirname(__DIR__));

require './vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

$validator = new Validator();
$validator->breakOnFirstError(true);

$rules = ['string' => 'required|not_empty|min:2|match_counts:(,)'];
$messages = [
    'string.required' => 'Parameter "string" required.',
    'string.not_empty' => 'Parameter "string" is empty.',
    'string.min' => 'Minimum length of string - :min characters',
    'string.match_counts' => "The number of opening and closing brackets does not match.",
];

$validator->validate($request->getParsedBody(), $rules, $messages);

if ($validator->failed()) {
    $response = new Response\TextResponse(
        $validator->errors()->first('string'),
        400
    );
} else {
    $response = new Response\TextResponse('Ok', 200);
}

http_response_code($response->getStatusCode());

echo $response->getBody();
