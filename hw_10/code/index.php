<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

require_once __DIR__ . "/vendor/autoload.php";

use APP\Response;
use APP\Request;
use APP\StringValidator;

if (Request::isRequestValid()) {
    sendResponse(400, "Malformed request");
    die(0);
}

$data = Request::getData()['string'];

if (StringValidator::isAllBracketsClosedProperly($data)) {
    sendResponse(200, "it's fine");
} else {
    sendResponse(400, "Brackets closed");
}


function sendResponse(int $code, string $message): void
{
    $response = new Response();
    $response->addCode($code);
    $response->setResponse($message);
    $response->send();
}
