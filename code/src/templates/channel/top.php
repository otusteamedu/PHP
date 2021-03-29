<?php

/**
 * @var YoutubeChannel[] $channels
 * @var mixed $error
 */

use App\Model\YoutubeChannel;

?>
<h1 class="h3">Top channels</h1>

<div class="row">
    <? if ($error) print_r($error) ?>
</div>

<ul class="list-group list-group-flush">
    <?php foreach ($channels as $ch) : ?>

        <h3><a class="list-group-item list-group-item-action" href="/channels/<?= $ch->getId() ?>">
                <?= $ch->getTitle() ?>
            </a>
        </h3>

    <?php endforeach; ?>
</ul>

