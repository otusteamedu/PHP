<?php

use App\Validator\Validator;
use Zend\Diactoros\{Response, ServerRequest};

chdir(dirname(__DIR__));

require './bootstrap.php';


/** @var ServerRequest $request */
$request = $container['request'];

/** @var Validator $validator */
$validator = $container['validator'];
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
