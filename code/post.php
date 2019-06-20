<?php
$request = 'string=(()()()()))((((()()()))(()()()(((()))))))';

$url = "http://192.168.1.144:8080";

$ch = curl_init();


curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close ($ch);

echo 'response: ' . var_dump($server_output);
echo '<br>http code: ' . var_dump($httpcode);


