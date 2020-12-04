<html lang="ru">
<head>
    <script src="/js/jquery-3.5.1.min.js"></script>
    <script src="/js/main.js"></script>
    <title>Задание по очередям</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<form onsubmit="sendForm(this); return false;" onclick="cleanMsgBox();">
    <label> Введите имя: <br>
        <input name="username" type="text" placeholder="Имя">
    </label>
    <label> Введите сообщение: <br>
        <textarea name="message" placeholder="Сообщение"></textarea>
    </label>
    <div class="button-box">
        <button type="submit">Отправить</button>
    </div>
    <div class="msg-box"></div>
</form>
</body>
</html>