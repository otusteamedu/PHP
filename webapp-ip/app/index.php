<?php 

    require_once 'vendor/autoload.php';

    // проверка
    $checker = new \Astrviktor\Tools\Checker\Checker();
    
    $checker->checkParenthesisPOSTandSERVER($_POST, $_SERVER);

