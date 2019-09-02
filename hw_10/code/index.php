<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

require_once __DIR__ . "/vendor/autoload.php";

use APP\Response;
use APP\Request;
use APP\Router;

$route = new Router(new Request());
$response = new Response();

switch ($route->getRoute()) {
    case Router::MALFORMED_REQUEST:
        $response->addCode(400);
        $response->setResponse("Malformed request");
        break;
    case Router::CORRUPTED_PARAMETER:
        $response->addCode(400);
        $response->setResponse("Brackets are closed improperly");
        break;
    case Router::PROPER_REQUEST:
        $response->addCode(200);
        $response->setResponse("it's fine");
        break;
}

$response->send();