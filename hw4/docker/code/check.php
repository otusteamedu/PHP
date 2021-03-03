<?php 
	namespace Otus\Checker;

	require('model/Checker.php');
	
	$str = $_POST['string'];

	$check = new Checker($str);
	$str_msg = $check->hooks();

    require('header.php');
?>

<body>
	<div class="container-fluid ml-4 mr-4">
        <h1>Результаты проверки</h1>
        <div>
	        <p>Была введена строка: <?=$str ?></p>
	        <p>Количество символов в строке: <?=strlen($str) ?></p>
	        <p>Корректность скобок в строке: <?=$str_msg ?></p>
        </div>
    </div>
</body>