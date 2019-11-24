<?php

use Controllers\EmailCheckerPageController as Controller;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EmailChecker</title>
</head>
<body>
<form action="emails/validate" method="POST">
    <label>
        <textarea placeholder="Enter emails, split with comma" name="emails"
                  style="height: 10em; width:480px"><?= $_GET["emails_list"] ?? "" ?></textarea>
    </label>
    <br/>
    <button type="submit">Проверка</button>
</form>

<div><a href="?emails_list=<?= Controller::getCorrectEmailsListStr() ?>">Корректные Email адреса</a></div>
<div><a href="?emails_list=<?= Controller::getIncorrectEmailsListStr() ?>">Некорректные Email адреса</a></div>
<div><a href="?emails_list=<?= Controller::getIncorrectMxEmailsListStr() ?>">
        Некорректные домены</a> (кирилица вперемечшку с латиницей в именах доменов)
</div>
<div><a href="?">Очистить</a></div>

</body>
</html>