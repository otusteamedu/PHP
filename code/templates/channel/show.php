<?php

/**
 * @var YouTubeChannel $channel
 * @var ChannelStatistic $stats
 * @var mixed $error
 */

use App\Model\ChannelStatistic;
use App\Model\YouTubeChannel;

?>
<h1 class="h3 visually-hidden">Channel</h1>

<div class="row">
    <?if ($error) print_r($error) ?>
</div>


<h1><?= $channel->getTitle() ?></h1>
<p><?= $channel->getDescription() ?></p>
<p><?= $channel->getPublishedAt()->format('d.m.Y H:m') ?></p>
<p>Likes: <?= $stats->getLikesCount() ?></p>
<p>Dislikes: <?= $stats->getDislikesCount() ?></p>

