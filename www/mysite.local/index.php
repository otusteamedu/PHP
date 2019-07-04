<?php

require $_SERVER['DOCUMENT_ROOT'] . '/src/PostStringHandler.php';

$PostStringHandler = new PostStringHandler($_POST['string']);
$PostStringHandler->showResult();