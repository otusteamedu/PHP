<?php
/*$post_data = array (
    "foo" => "bar",
    "query" => "Nettuts",
    "action" => "Submit"
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/index.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close($ch);
var_dump($output);*/

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,'http://localhost:80');
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//для возврата результата в виде строки, вместо прямого вывода в браузер
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
$returned = curl_exec($ch);
$info = curl_getinfo($ch);
var_dump($info);
var_dump($returned);
curl_close ($ch);
