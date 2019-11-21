<?php

use App\{MySQLDatabaseConnector, MySQLQueries, ProductActiveRecord};

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$dbConnector = new MySQLDatabaseConnector();
$queries = new MySQLQueries();
//create new instance
$product = new ProductActiveRecord($dbConnector, $queries);
//get by id
$chair = $product->findByID(2);
var_dump($chair);

//update
//$chair->setPrice(5500);
//$chair->update();
//var_dump($chair);

//insert
//$newChair = $chair->setTitle('chair3')->insert();
//var_dump($newChair);

//delete
//$chair->delete();

//custom business logic function
//var_dump($chair->isExpensive());

//get all items
//var_dump($product->findAll());