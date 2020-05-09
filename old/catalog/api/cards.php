<?php

require("config.php");

$token = $_COOKIE["catalog_token"];

$cataloger = new cataloger($f3);
$user = $cataloger->authorize($token);

if(!isset($user)) return;

$sql = "SELECT * FROM catalogershops 
	LEFT JOIN catalog ON catalog.id = catalogershops.cardId
WHERE catalogerId=:id";

$cards = $db->exec($sql, ["id"=>$user["id"]]);

if($cards !== false && count($cards) > 0) {
	$card = $cards[0];


	$sql = "SELECT * FROM category WHERE card = :card";
	$catalog = $db->exec($sql, ["card"=>$card["cardId"]]);

	if(isset($catalog) && count($catalog) > 0) {
		$categoryId = $catalog[0]["id"];
		$sql = "SELECT * FROM product WHERE category = :category";
		$products = $db->exec($sql, ["category"=>$categoryId]);

		foreach($products as $key => $product) {
			$products[$key]["description"] = json_decode($product["description"], true);
		}

	}
}

// echo "<pre>".print_r($catalog, 1)."</pre>";

getResult(["cards"=>$cards, "catalog"=>$catalog, "products"=>$products], 0);