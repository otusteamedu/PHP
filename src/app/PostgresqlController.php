<?php
namespace Paa\App;

use PDO;
use PDOStatement;

class PostgresqlController 
{
    public function __construct()
    {
	global $config;
	$postgresql = $config['postgresql'];
	
	try {
	    $pdo = new PDO('pgsql:host='.$postgresql['dbHost'].';port='.$postgresql['dbPort'].';dbname='.$postgresql['dbName'].';user='.$postgresql['dbUser'].';password='.$postgresql['dbPassword']);
	}
	catch( PDOException $Exception ) {
	
	    throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
	}
	
	return $pdo;

     }
}