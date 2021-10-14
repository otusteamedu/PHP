<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <link rel="stylesheet" href="/assets/css/main.css"/>
</head>
<body>
<div class="error" style="display: <?php echo isset($error) && ($error === true) ? 'block' : 'none'?>;">Ошибка входа!</div>
Вход на сайт:
<form action="/login" method="post" enctype="multipart/form">
    <span class="">Имя пользователя:</span><input type="text" name="login" value="<?php echo $login ?? ''?>"/>
    <span>Пароль:</span><input type="password" name="password" value="<?php echo $password ?? ''?>"/>
    <button type="submit">Login</button>
</form>
</body>
</html>