<?php
require_once "vendor/autoload.php";

use Jekys\Config;
use Jekys\Queue;
use Jekys\Statistics;

$config = Config::getInstance();

/** Common settings **/
$config->queue_name = 'get-channel-data';

/** YouTube API settings **/
$config->youtube_app_name = 'Youtube Channels Stats';
$config->youtube_json = '/var/www/secret.json';
$config->youtube_scopes = [
    'https://www.googleapis.com/auth/youtube.readonly',
];

/** MongoDB settings **/
$config->mongo_host = $_SERVER['MONGO_HOST'];
$config->mongo_port = $_SERVER['MONGO_PORT'];
$config->mongo_port = $_SERVER['MONGO_PORT'];
$config->mongo_db = $_SERVER['MONGO_HOST'];
$config->mongo_collection = $_SERVER['MONGO_COLLECTION'];

/** RabbitMQ settings **/
$config->rabbitmq_host = $_SERVER['RABBITMQ_HOST'];
$config->rabbitmq_user = $_SERVER['RABBITMQ_USER'];
$config->rabbitmq_pass = $_SERVER['RABBITMQ_PASS'];

$stats = new Statistics(
    $config->mongo_host,
    $config->mongo_port,
    $config->mongo_db,
    $config->mongo_collection
);

$queue = new Queue(
    $config->rabbitmq_host,
    5672,
    $config->rabbitmq_user,
    $config->rabbitmq_pass,
    $config->queue_name
);
