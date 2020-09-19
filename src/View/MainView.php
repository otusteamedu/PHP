<?php

require $_SERVER['DOCUMENT_ROOT'] . '/src/Controllers/MainViewController.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Youtube-Analyse</title>
</head>
<body>

<h3>Отобразить сохраненные данные статистики по каналам youtube:</h3>
<form action="/src/View/MainView.php" method="post">
    <input type="submit" value="показать" name="show">
</form>
<br>
<hr>
<h3>Введите наименование канала для добавления в статистику:</h3>
<form action="/src/View/MainView.php" method="post">
    <input type="text" name="name" placeholder="наименование канала">
    <input type="submit" name="submit" placeholder="отправить">
</form>
</body>
</html>