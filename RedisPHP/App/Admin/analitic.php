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
<form method="post" action="../Actions/addEvent.php">
    <label about="priority">
        <b>Приоритет</b>
        <input type="number" name="priority"><br>
    </label>
    <label about="condition">
        <b>Параметры</b>
        <input type="text" name="condition"><br>
    </label>
    <label about="event">
        <b>Событие</b>
        <input type="text" name="event"><br>
    </label>
    <button type="submit">Добавить событие</button>
    <br>
</form>
<hr width="300px" align="left">
<form method="post" action="/App/Actions/deleteOne.php">
    <label about="number"></label>
    <b>Номер</b>
    <input type="number" name="number"><br>
    </label>
    <button type="submit">Удалить событие</button>
    <br>
</form>
<hr width="300px" align="left">
<form method="post" action="/App/Actions/deleteAll.php">
    <button type="submit">Удалить все</button>
</form>

<hr width="300px" align="left">
<a href="/App/Actions/findAll.php">Посмотреть все события</a>
</body>
</html>