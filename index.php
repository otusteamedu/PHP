<?php
$host  = $_SERVER['HTTP_HOST'];
$extra = 'src/View/MainView.php';
header("Location: http://$host/$extra");