<?php

namespace View;

class MainView extends View
{
    public function output()
    {
        echo '
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Youtube-Analyse</title>
</head>
<body>

<h3>Отобразить сохраненные данные статистики по каналам youtube:</h3>
<form action="/" method="get">
    <input type="submit" value="Показать" name="show">
</form>
<br>
<hr>
<h3>Введите наименование канала для добавления в статистику:</h3>
<form action="/" method="get">
    <input type="text" name="name" placeholder="наименование канала">
    <input type="submit" name="submit">
</form>
</body>
</html>';
    }
}