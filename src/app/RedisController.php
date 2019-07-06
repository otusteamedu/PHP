<?php
namespace Paa\App;

use Predis;

class RedisController 
{
    public function __construct()
    {
	global $config;
	$redisCfg = $config['redis'];
        return new Predis\Client(array('database' => $redisCfg["dbName"], 'host' => $redisCfg["dbHost"], 'port' => $redisCfg["dbPort"]));
     }
                     
}