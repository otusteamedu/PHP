<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Factory\AppFactory;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

include_once 'vendor/autoload.php';
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();
// точка доступа с типом direct (direct, topic, headers и fanout) имя direct_logs
$channel->exchange_declare('direct_logs', 'direct', false, false, false);
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->add(function (Request $request, Handler $handler){
    $response = $handler->handle($request);
    $response->withHeader('Content-Type', 'application/json');
    return $response;
});
$app->get('/', function (Request $request, Response $response, array $args) {
    $data = array('success' => 'Y');
    $payload = json_encode($data);
    $response->getBody()->write($payload);
    return $response;
});
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});
$app->post('/action', function(Request $request, Response $response) {
    $data = array('name' => 'Bob', 'age' => 40);
    $payload = json_encode($data);
    $response->getBody()->write($payload);
    return $response;
});
$app->post('/book/add', function(Request $request, Response $response, array $args) use ($channel) {
    $arResult = array(
        'ChannelId' => $channel->getChannelId(),
        'uid' => uniqid('add_'),
    );
    $allPostPutVars = $request->getParsedBody();
    $data = $allPostPutVars;
    $data['uid'] = $arResult['uid'];
    $payload = json_encode($data);
    $channel->queue_declare('hello', false, false, false, false);
    $msg = new AMQPMessage($payload);
    $channel->basic_publish($msg, '', 'hello');
    $response->getBody()->write($payload);
    return $response;
});
$app->run();
$channel->close();
$connection->close();
?>