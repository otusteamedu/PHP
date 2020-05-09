<?php

require("config.php");

$referer = $_SERVER["HTTP_REFERER"];

// if($referer != "http://lyubimiigorod.ru/catalog/index.php") {
// 	getResult(["msg"=>"Получить заказы можно только с сайта"], 1);
// 	return;
// }

$company_id = $f3->get("POST.company_id");

$token = $_COOKIE["catalog_token"];

$cataloger = new cataloger($f3);
$user = $cataloger->authorize($token);

if(!isset($user)) return;


$sql = "SELECT * FROM catalogercompany 
	LEFT JOIN companies ON companies.id = catalogercompany.company_id
WHERE cataloger_id=:id";

$cards = $db->exec($sql, ["id"=>$user["id"]]);

$grant = false;

foreach($cards as $card) {
	if($company_id == $card["id"]) $grant = true;
}

if($grant == false) return;

$sql = "SELECT * FROM orders WHERE company_id = :company_id AND (state = 0 OR state = 1)";
$orders = $db->exec($sql, ["company_id"=>$company_id]);

getResult($orders);