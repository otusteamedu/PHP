<?php
require 'controllers/MainController.php';
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Homework 2-1</title>
</head>
<body>
<h3>Please enter string and click to the button</h3>
<form action="/" method="post">
    <input type="text" name="string" pattern="^[()]+$" placeholder="Enter string here..." title="Only ( and ), also > 10">
    <input type="submit" placeholder="enter">
</form>
<h3><?= $mainController->getResponse() ?></h3>
</body>
</html>