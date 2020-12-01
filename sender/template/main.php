<html lang="ru">
<head>
    <script src="/js/jquery-3.5.1.min.js"></script>
    <script>
        function sendForm(form) {
            $(".msg-box").text("...");
            $.post("/", $(form).serialize(), function (data) {
                $(".msg-box").text(data);
                form.reset();
            });
        }
    </script>
    <title>Задание по очередям</title>
    <style>
        form {
            width: 450px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px #cacaca;
        }

        label, .button-box, .msg-box {
            display: block;
            margin: 15px;
        }

        textarea, input {
            width: 100%;
        }
    </style>
</head>
<body>
<form onsubmit="sendForm(this); return false;" onclick="$('.msg-box').text('')">
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