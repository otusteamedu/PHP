<?php
namespace Paa\App;

class RabbitController 
{
    public function __construct()
    {
	global $config;
        $rabbit = $config['rabbit'];
        return new \PhpAmqpLib\Connection\AMQPStreamConnection($rabbit['dbHost'], $rabbit['dbPort'], $rabbit['dbUser'], $rabbit['dbPassword']);
     }
}