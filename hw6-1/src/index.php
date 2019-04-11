<?php


function getBracketsString() 
{
	if (!isset($_POST['string'])) {
		sendBadResponse();
	}
	return $_POST['string'];
}


function checkBrackets($string) 
{
	$len = strlen($string);
	$open = 0;
	$close = 0;
	
	for($i=0; $i<$len; $i++) {
		if ($string[$i] == "(") {
			$open++;
		}
		if ($string[$i] == ")") {
			$close++;
		}
		if ($close > $open) {
			return false;
		}
	}
	if ($close != $open) {
		return false;
	}
	return true;
}


function sendBadResponse()
{
	header('HTTP/1.1 400 Bad Request');
	exit;
}


function sendGoodResponse()
{
	header('HTTP/1.1 200 OK');
	exit;
}


// Main
$bracketsString = getBracketsString();
$stringIsGood = checkBrackets($bracketsString);
if (!$stringIsGood) {
	sendBadResponse();
}
sendGoodResponse();
