<?php

require("config.php");

$referer = $_SERVER["HTTP_REFERER"];

// if($referer != "http://lyubimiigorod.ru/catalog/index.php") {
// 	getResult(["msg"=>"Получить заказы можно только с сайта"], 1);
// 	return;
// }

$id = $f3->get("POST.id");

$token = $_COOKIE["catalog_token"];

$cataloger = new cataloger($f3);
$user = $cataloger->authorize($token);

if(!isset($user)) return;


$sql = "SELECT * FROM catalogercompany 
	LEFT JOIN catalog ON catalog.id = catalogercompany.company_id
WHERE cataloger_id=:id";

$cards = $db->exec($sql, ["id"=>$user["id"]]);

$grant = false;

$sql = "SELECT * FROM orders WHERE id = :id";

$order = $db->exec($sql, ["id"=>$id]);

$sql = "SELECT o.id, c.name as category, p.id as p_id, p.name, p.thumbnail, p.cost, o.cnt, o.include, p.cost * o.cnt as sum from order_details o
			left join product p ON p.id = o.product_id
			left join category c ON c.id = p.category
			where order_id = :id;";

$details = $db->exec($sql, ["id"=>$id]);

if(isset($order) && count($order) == 1) {

    $sql = "UPDATE orders SET opened = 1 WHERE id = :id;";
    $db->exec($sql, ["id"=>$id]);

	getResult(["order"=>$order[0], "details"=>$details]);
}