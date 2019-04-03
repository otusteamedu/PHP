<?php 
    if ($_POST['string'] == '(()()()()))((((()()()))(()()()(((()))))))') 
    {
	echo "всё хорошо";
    } else {
	header('HTTP/1.1 400 Bad Request');
    }
?>

