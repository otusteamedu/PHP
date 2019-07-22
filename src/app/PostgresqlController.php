<?php
namespace Paa\App;

class PostgresqlController 
{
    public function __construct()
    {
	global $config;
	$postgresql = $config['postgresql'];
	
	try {
	    return new \PDO('pgsql:host='.$postgresql['dbHost'].';port='.$postgresql['dbPort'].';dbname='.$postgresql['dbName'], $postgresql['dbUser'], $postgresql['dbPassword']);
	} catch(PDOException $e) {
	    die('Unable to open database connection'); 
	} 

     }
}