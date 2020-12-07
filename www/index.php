<?php

//use \Bramus\Router\Router;
//use PhpAmqpLib\Connection\AMQPStreamConnection;
//use PhpAmqpLib\Message\AMQPMessage;

use Drivers\MongodbDriver;


define('DS', DIRECTORY_SEPARATOR);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);

include_once(ROOT . DS . 'vendor' . DS . 'autoload.php');

//$mongodb = new MongodbDriver();
//$mongodb->connect('mongodb://test:test@mongodb', 'project');
//$id = $mongodb->insert('status', ['test' => 111]);
//$mongodb->update('status', $id, ['test' => 'ddd555']);
/*$route = new Router();

$route->get('/app', '\Controllers\QueueController@index');

$route->run();*/



/*$connection = new AMQPStreamConnection('rabbitmq', 5672, 'test', 'test');
$channel = $connection->channel();*/


//$channel->queue_declare('log', false, false, false, false);


/*$msg = new AMQPMessage('test2222!' . rand(1,1000));
$channel->basic_publish($msg, '', 'log');*/

//echo ' [x] Sent '.$msg->body."\n<br />";


/*$callback = function ($msg) {
 * тут
};

$channel->basic_consume('test', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

//$channel->close();
//$connection->close();
