<?php

use Controller\YoutubeTopChannelsPageController as Controller;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link type="text/css" rel="stylesheet" href="/css/style.css"/>
    <title>Youtube::Top Channels</title>
</head>
<body>
<h1>Top <?= Controller::getChartValue() ?> Channels</h1>

<div class="int15">
    <<< <a href="/youtube">Список каналов</a>
</div>

<div class="int1">
    <table>
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>


        <?php foreach (Controller::getTopChannels() as $i => $statistics) { ?>

            <tr>
                <td><span style="cursor: help; color: cornflowerblue"
                          title="mongoID: <?= $statistics->getChannel()->getId() ?>"><?= $i + 1 ?></span></td>
                <td><a href="https://www.youtube.com/channel/<?= $statistics->getChannel()->getHashId() ?>"
                       target="_blank">
                        <?= $statistics->getChannel()->getTitle() ?>
                    </a></td>
                <td>
                    <?php if (mb_strlen($statistics->getChannel()->getDescription()) > 72) { ?>
                        <span title="<?= htmlspecialchars($statistics->getChannel()->getDescription()) ?>"><?= mb_substr($statistics->getChannel()->getDescription(), 0, 72) ?></span>...
                    <?php } else { ?>
                        <?= $statistics->getChannel()->getDescription() ?>
                    <?php } ?>
                </td>
                <td>
                    <div class="rate_scale">
                        <strong><?= number_format($statistics->getRating(), 2) ?></strong>%
                        <div class="rate_value" style="width: <?= $statistics->getRating() ?>%"></div>
                    </div>
                </td>
            </tr>

        <?php } ?>
        </tbody>
    </table>
</div>
