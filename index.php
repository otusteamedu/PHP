<?php

require 'vendor/autoload.php';
use Brackets\Controllers\CheckQuotes;

if (isset($_POST['string'])) {
    
    $str = trim($_POST['string']);
    (new CheckQuotes($str))->checkStringQuotes();

}


?>


<form action="index.php" method="POST">
  <input type="text" name="string" value="(()()()()))((((()()()))(()()()(((()))))))">
  <input type="submit">
</form>