<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('./vendor/autoload.php');

if (isset($_REQUEST['text'])) {
    $text = substr($_REQUEST['text'], 0, 30);
} else {
    $text = 'Hello World!';
}

$imgX = isset($_REQUEST['x']) ? (int) $_REQUEST['x'] : 100 ;
$imgY = isset($_REQUEST['y']) ? (int) $_REQUEST['y'] : 100 ;

$imgGenerator = new WebsysForever\getTextImg($text, $imgX, $imgY);
$imgGenerator->sendImg();