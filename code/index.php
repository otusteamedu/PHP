<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<!-- указываем в action просто адрес сервера без какого-то конкретного хоста -->
<form action="http://192.168.1.144:8080" method="post">
    <input name="string" value="test here"/>
    <button type="submit">Send</button>
</form>
</body>
</html>