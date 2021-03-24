<?php

/**
 * @var YoutubeChannel $channel
 * @var ChannelStatistic $stats
 * @var mixed $error
 * @var YoutubeVideo[] $video
 */

use App\Model\ChannelStatistic;
use App\Model\YoutubeChannel;
use App\Model\YoutubeVideo;

?>

<div class="row">
    <?if ($error) print_r($error) ?>
</div>


<h1><?= $channel->getTitle() ?></h1>
<p><?= $channel->getDescription() ?></p>
<p><?= $channel->getPublishedAt()->format('d.m.Y H:m') ?></p>
<p>Likes: <?= $stats->getLikesCount() ?></p>
<p>Dislikes: <?= $stats->getDislikesCount() ?></p>

<h2 class="h3">Видео канала</h2>
<ul class="list-group list-group-flush">
    <?php foreach ($video as $v) :?>
        <li class="list-group-item">
            <h3 class="h4"><?= $v->getTitle() ?></h3>
            <p><?= $v->getDescription() ?></p>
        </li>
    <?php endforeach; ?>
</ul>

