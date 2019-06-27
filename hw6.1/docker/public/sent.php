<?php

$fp = fsockopen('localhost', 8080);

$array = ['string' => '()'];
$array = http_build_query($array);

fwrite($fp, "POST /index.php HTTP/1.1\r\n");
fwrite($fp, "Host: localhost\r\n");
fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
fwrite($fp, "Content-Length: ".strlen($array)."\r\n");
fwrite($fp, "Connection: close\r\n");
fwrite($fp, "\r\n");

fwrite($fp, $array);

header('Content-type: text/plain');
while (!feof($fp)) {
    echo fgets($fp, 1024);
}
fclose($fp);

