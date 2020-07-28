<?php

/**
 *  @var array $data - массив входящих переменных
 */
?>
<?php include 'header.php'; ?>
<?php foreach ($data as $article): ?>
    <h2><a href="/article/view/<?= $article->getId(); ?>"><?= $article->getName() ?></a></h2>
    <h4>Created: <?= $article->getCreatedAt() ?>
        &nbsp;&nbsp;&nbsp;
        Author:  <?= $article->getAuthor()->getNickname() ?></h4>
    <p><?= $article->getText() ?></p>
    <hr>
<?php endforeach; ?>
<?php include 'footer.php'; ?>
