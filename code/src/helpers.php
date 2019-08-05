<?php

use Opis\JsonSchema\Schema;
use Opis\JsonSchema\Validator;
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;

function url(?string $name = null, $parameters = null, ?array $getParams = null): Url
{
    return Router::getUrl($name, $parameters, $getParams);
}

/**
 * @return \Pecee\Http\Response
 */
function response(): Response
{
    return Router::response();
}

/**
 * @return \Pecee\Http\Request
 */
function request(): Request
{
    return Router::request();
}

/**
 * Get input class
 * @param string|null $index Parameter index name
 * @param string|null $defaultValue Default return value
 * @param array ...$methods Default methods
 * @return \Pecee\Http\Input\InputHandler|\Pecee\Http\Input\IInputItem|string
 */
function input($index = null, $defaultValue = null, ...$methods)
{
    if ($index !== null) {
        return request()->getInputHandler()->getValue($index, $defaultValue, ...$methods);
    }
    return request()->getInputHandler();
}

/**
 * @param string $url
 * @param int|null $code
 */
function redirect(string $url, ?int $code = null): void
{
    if ($code !== null) {
        response()->httpCode($code);
    }
    response()->redirect($url);
}

/**
 * Get current csrf-token
 * @return string|null
 */
function csrfToken(): ?string
{
    $baseVerifier = Router::router()->getCsrfVerifier();
    if ($baseVerifier !== null) {
        return $baseVerifier->getTokenProvider()->getToken();
    }
    return null;
}

/**
 * @return array|mixed
 */
function getDataFromPutRequest()
{
    $output = [];
    $contents = file_get_contents("php://input");

    // if json
    if (strpos(trim($contents), '{') === 0) {
        $post = json_decode($contents, true);
        if ($post !== false) {
            $output += $post;
        }
        return $output;
    }

    parse_str($contents, $output);
    foreach ($output as $key => $value) {
        unset($output[$key]);
        $output[str_replace('amp;', '', $key)] = $value;
    }

    return $output;
}

/**
 * @return array
 * @throws Exception
 */
function inputValidator(): array
{
    $data = request()->getMethod() === 'put' ? getDataFromPutRequest() : request()->getInputHandler()->all();

    $schema = Schema::fromJsonString(file_get_contents('../schema.json'));
    $validator = new Validator();
    $result = $validator->schemaValidation((object)$data, $schema);

    if ($result->hasErrors()) {
        throw new \Exception($result->getFirstError()->keyword() . ': ' .
            implode(' ', $result->getFirstError()->keywordArgs()), 400);
    }

    return $data;
}


function getJob($job)
{
    response()->json([
        'status'=>'ok',
        'result' => ($job instanceof \crazydope\theater\Model\JobInterface) ? $job->getValue() : null
    ]);
}