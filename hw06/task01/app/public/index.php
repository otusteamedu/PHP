<?php
error_reporting(E_ERROR);
require '../vendor/autoload.php';
?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Проверка email</title>
</head>
<body>
<h1>Проверка email</h1>
<form action="" novalidate method="post">
    <input type="email" name="email"/> <input type="submit"/>
</form>
<p>
    <? if (isset($_POST['email'])){
    $email = $_POST['email'];
    $obCheck = new \WebFarrock\EmailChecker\Check();
    $obCheck->addChecker(new \WebFarrock\EmailChecker\RuleMxRecord());
    $result = $obCheck->check($email);

    if ($result->isSuccess()) { ?>
        email "<?= $email ?>" успешно прошел проверку <br/>
        <?php
    } else { ?>
        email "<?= $email ?>" не прошел проверку <br/>
        <?php
        echo '<pre>';
        print_r($result->getErrorMessages());
        echo '</pre>';
    }
    ?>
</p>
<? } ?>
</body>
</html>