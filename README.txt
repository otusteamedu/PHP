На серверах, для просмотра кто именно сейчас обрабатывает запрос
добавил для просерки
<?php
echo $_SERVER['SERVER_NAME'] . PHP_EOL;
echo $_SERVER['SERVER_ADDR'] . PHP_EOL;

?>

Пример index.php

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!-- only for testing -->

<p>
<?php
echo $_SERVER['SERVER_NAME'] . PHP_EOL;
echo $_SERVER['SERVER_ADDR'] . PHP_EOL;

?>
</p>
<form action="reposter.php" method="post">
    <input name="string">
    <button>submit</button>
</form>

</body>
</html>

Запуск 
docker run -p 8080:80 nginx_load
