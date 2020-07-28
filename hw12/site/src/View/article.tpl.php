<?php
/**
 *  @var array $data - массив входящих переменных
 *  @var object $author
 */
?>

<?php include 'header.php'; ?>

    <h2>
        <a href="/article/view/<?= ($data['data'])->getId() ?>"><?= $data['data']->getName() ?></a>
    </h2>
    <h4>Created: <?= $data['data']->getCreatedAt() ?>
        &nbsp;&nbsp;&nbsp;
        Author:  <?= $data['author']->getNickname() ?>
    </h4>
    <p><?= $data['data']->getText() ?></p>
    <br>

<?php include 'footer.php'; ?>
