<?php
namespace Paa\App;

class PostgresqlController 
{
    public function __construct()
    {
	global $config;
	$postgresql = $config['postgresql'];
	return new \PDO('pgsql:host='.$postgresql['dbHost'].';port='.$postgresql['dbPort'].';dbname='.$postgresql['dbName'], $postgresql['dbUser'], $postgresql['dbPassword']);
     }
     
     
}