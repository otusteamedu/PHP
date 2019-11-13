<?php
require_once "vendor/autoload.php";

$dbConnector = new \App\Database();
$dbConnection = $dbConnector->connect();
//create new instance
$product = new \App\ProductActiveRecord($dbConnection);
//get by id
$chair = $product::find($dbConnection,2);
//var_dump($chair);

//update
//$chair->setPrice(2500);
//$chair->update();
//var_dump($chair);

//insert
//$newChair = $chair->setTitle('chair2')->insert();
//var_dump($newChair);

//delete
//$chair->delete();

//custom business logic function
//var_dump($chair->isExpensive());

//get all items
//var_dump($product::findAll($dbConnection));