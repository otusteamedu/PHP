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

        <li class="list-group-item">
            <h3><a href="/<?=$ch->getId()?>"<?= $ch->getTitle() ?></a></h3>
            <p><?= $ch->getDescription() ?></p>
        </li>
    <?php endforeach; ?>
</ul>

