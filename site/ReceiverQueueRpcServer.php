
<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
use App\Factory;
$factory= new Factory();
$ReceiverQueue=$factory->create('ReceiverQueueRpcServer');
$ReceiverQueue->queueWait();
$ReceiverQueue->queueClose();

