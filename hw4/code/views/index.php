<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>otus.ru</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <script src=""></script>
</head>
<body>

    <h1>Homework 4</h1>
    <p></p>
    <p>POST / HTTP/1.1</p>
    <form method="post" action="/">
        <p>
            Строка для отправки должна быть не пустой и иметь длину от 2 до 256 символов.
            <br />
            Не правильный пример: "(()()()()))((((()()()))(()()()(((()))))))"
            <br />
            Правильный пример: "(()()()())((((()()()))(()()()(((()))))))"
        </p>
        * <input class="input-string" name="string" value="<?php echo $_POST['string'] ?? ''; ?>" />
        <br />
        <span class="color-green"><?php echo $params['success'] ?? ''; ?></span>
        <span class="color-red"><?php echo $params['error'] ?? ''; ?></span>
        <br />
        <input type="submit" value="Отправить" />
    </form>

</body>
</html>
