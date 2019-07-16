<?php
namespace Paa\App;

use MongoDB;

class MongoController 
{
    public function __construct()
    {
	global $config;
	$mongoCfg = $config['mongo'];
        return $manager = new MongoDB\Driver\Manager("mongodb://" . $mongoCfg['dbHost'] . ":" . $mongoCfg['dbPort']);
     }

             
}