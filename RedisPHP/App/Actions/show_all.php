<?php
/**
 * @var $event \App\Models\Event $datum
 */
?>

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
<?php foreach ($data as $key => $datum) {
    ?>
    <h2>Ключ : <?php echo $key; ?> </h2>
    <h3> Собятие :<?php echo $datum->getEvent(); ?></h3>
    <h4> Параметры :<?php echo implode($datum->getConditions(), ' - '); ?></h4>
    <p> Приоритет :<?php echo $datum->getPriority(); ?></p>
    <hr>
    <?php
}
?>
<a href="../../index.php">На главную</a>

</body>
</html>