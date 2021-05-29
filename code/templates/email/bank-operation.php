<?php

/**
 * @var string $username
 * @var string $dateStart
 * @var string $dateEnd
 * @var \App\Entity\BankOperation $operation
 * @var \Doctrine\Common\Collections\ArrayCollection $operations
 */

?>

<html lang="ru_RU">
<head>
    <style>
        h1 {font-size: large}
        h2 {font-size: medium}
        span {margin-left: 2em;}
    </style>
	<title>Банковские операции</title>
</head>
<body>
<h1>Здравствуйте, <?= $username ?></h1>
<h2>Ваши банковские операции в период с
    <?= $dateStart ?> по <?= $dateEnd ?>
</h2>
<?php foreach ($operations as $operation): ?>
<p>
    <?= $operation->getCreatedAt()->format('d.m.Y H:i:s') ?>
    <span>Сумма:</span> <span><?= $operation->getSum() ?>руб.</span>
</p>
<?php endforeach; ?>
</body>
</html>
