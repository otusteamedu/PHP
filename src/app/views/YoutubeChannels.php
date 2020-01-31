<?php

use Controller\YoutubePageController as Controller;
use Filter\YoutubeChannelsFilter;
use Filter\YoutubeVideosFilter;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link type="text/css" rel="stylesheet" href="/css/style.css"/>
    <title>Youtube Channels</title>
</head>
<body>
<h1>Youtube</h1>

<h2>Каналы Youtube</h2>
<div class="int15">

    <div class="int1">
        <h3>Импорт каналов</h3>
        <p> id каналов, разделённые запятыми </p>

        <div class="int05">
            <form action="/youtube/channels/import" method="post" target="_blank">
                <label>
                    <textarea name="list" cols="86"
                              rows="10"><?= Controller::getChannelsHashIdList($chCount) ?></textarea>
                </label>
                <br/>
                <input type="submit" value="Импортировать список каналов"/>
            </form>
            <em>данные для теста: <strong><?= $chCount ?></strong> каналов</em>
        </div>
    </div>

    <h3>
        Топ каналов
    </h3>
    <div>
        <form action="/youtube/channels/top" method="get">
            <label>
                Кол-во топ-каналов
                <input name="<?= YoutubeChannelsFilter::LIMIT ?>" value="10" type="number" step="1" max="<?= count(Controller::getYoutubeChannels()) ?>" min="3">
            </label>
            <input type="submit" value="Показать"/>
        </form>
    </div>

    <div class="int2">

        <h3>Коллекция каналов</h3>
        <div class="int05">
            <a href="/youtube/channels/delete" target="_blank">Удалить коллекцию каналов</a>
        </div>
        <div class="int05">
            <a href="/youtube/channels">в JSON</a>
        </div>
        <div class="int1">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание канала</th>
                    <th><span class="like"></span> / <span class="dislike"></span></th>
                    <th>Список видео</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <?php foreach (Controller::getYoutubeChannels() as $i => $youtubeChannel) { ?>
                    <tr>
                        <td><span style="cursor: help; color: cornflowerblue"
                                  title="mongoID: <?= $youtubeChannel->getId() ?>"><?= $i + 1 ?></span></td>
                        <td><?= $youtubeChannel->getHashId() ?></td>
                        <td>
                            <a href="https://www.youtube.com/channel/<?= $youtubeChannel->getHashId() ?>"
                               target="_blank">
                                <?= $youtubeChannel->getTitle() ?>
                            </a>
                        </td>
                        <td>
                            <?php if (mb_strlen($youtubeChannel->getDescription()) > 72) { ?>
                                <span title="<?= htmlspecialchars($youtubeChannel->getDescription()) ?>"><?= mb_substr($youtubeChannel->getDescription(), 0, 72) ?></span>...
                            <?php } else { ?>
                                <?= $youtubeChannel->getDescription() ?>
                            <?php } ?>
                        </td>
                        <td>
                            <div class="rate_scale">
                                <strong><?= $youtubeChannel->getLikesCount() ?></strong>
                                / <?= $youtubeChannel->getDislikesCount() ?>
                                <div class="rate_value" style="width: <?= $youtubeChannel->getRate(100) ?>%">
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="/youtube/videos?<?= YoutubeVideosFilter::CHANNEL_ID ?>=<?= $youtubeChannel->getHashId() ?>"
                               target="_blank">JSON</a>&nbsp;&nbsp;
                            <a href="/youtube/channel/videos?<?= YoutubeVideosFilter::CHANNEL_ID ?>=<?= $youtubeChannel->getHashId() ?>">HTML</a>
                        </td>
                        <td>
                            <a href="/youtube/channels/delete?<?= YoutubeChannelsFilter::HASH_ID ?>=<?= $youtubeChannel->getHashId() ?>"
                               target="_blank">Удалить</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>
</div>

</body>
</html>