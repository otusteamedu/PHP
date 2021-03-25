<?php

/**
 * @var YoutubeChannel[] $channels
 * @var mixed $error
 */

use App\Model\YoutubeChannel;

?>
<h1 class="h3 visually-hidden">Channel</h1>

<div class="row">
    <?if ($error) print_r($error) ?>
</div>

<ul class="list-group list-group-flush">
    <?php foreach ($channels as $ch) :?>
    <a href="/<?=$ch->getId()?>" class="list-group-item list-group-item-action">
        <h3><?= $ch->getTitle() ?></h3>
        <p><?= $ch->getDescription() ?></p>
    </a>
    <?php endforeach; ?>
</ul>

