<?php
/**
 * @var string $content
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <ul>
      <li><a href="/order/index">Главная</a></li>
      <li><a href="/order/add">Добавить заказ</a></li>
    </ul>

    <?php include 'App/Views/'.$content ?>
</body>
</html>
