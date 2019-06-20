<?php
if (
	empty($_POST['string'])
	||
	empty($_SERVER['CONTENT_LENGTH'])
	||
	(int)$_SERVER['CONTENT_LENGTH'] != strlen($_POST['string'])+7 //string= this is 7 symbols
) {
  //http_response_code(400);
  header('Status: 400 Bad request');
  exit;
}

//send OK header
header('Status: 200 OK');

//count and output how much symbols ( and ) in the string
echo ' In income string:' . PHP_EOL .$_POST['string'] . PHP_EOL . ' we have found "(" = ' .
    substr_count($_POST['string'], '(')
    . ' and ")" = ' .
    substr_count($_POST['string'], ')')
    . ' times';

