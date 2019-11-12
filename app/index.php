<?php
require_once "vendor/autoload.php";

$dbConneсtion = new PDO('mysql:host=mysql;dbname=hw', 'root', 'root', [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

//create new instance
$product = new \App\ProductActiveRecord($dbConneсtion);
//get by id
$chair = $product::find($dbConneсtion,2);
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
//var_dump($product::findAll($dbConneсtion));