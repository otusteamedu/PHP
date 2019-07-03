<?php

include('vendor/autoload.php');

use Otus\Models\Message;
//$conStr = "mysql:host=localhost;port=3306;dbname=cinema;user=postgres;password=adminPassword";
$pdo = new PDO('mysql:dbname=cinema;host=127.0.0.1', 'testuser', 'testpassword');
$message = new Message();
$message->message = 123123123;
$message->save();