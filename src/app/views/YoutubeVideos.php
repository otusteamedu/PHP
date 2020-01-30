<?php

use Controller\YoutubeVideosPageController as Controller;
use Filter\YoutubeVideosFilter;

$channelInfo = Controller::getChannelInfo();
$channelVideos = Controller::getVideos();

?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <link type="text/css" rel="stylesheet" href="/css/style.css"/>
        <title>Youtube::Channels Video</title>
    </head>
<body>
    <h1>Список видео Youtube канала</h1>

    <div class="int15">
        <<< <a href="/youtube">Список каналов</a>
    </div>
<?php if ($channelInfo->isExists()) { ?>
    <h2 class="title"><?= $channelInfo->getTitle() ?></h2>
    <p class="description">
        <?= $channelInfo->getDescription() ?>
    </p>
    <div class="int15">
        <a href="/youtube/videos/delete?<?= YoutubeVideosFilter::CHANNEL_ID ?>=<?= $channelInfo->getHashId() ?>"
           target="_blank">Удалить все <strong>(<?= count($channelVideos) ?>)</strong> видео канала</a>
    </div>
    <div class="int1">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th><span class="like"></span></th>
                <th><span class="dislike"></span></th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($channelVideos as $i => $video) { ?>
                <tr>
                    <td>
                        <?= $i + 1 ?>
                    </td>
                    <td>
                        <?= $video->getHashId() ?>
                    </td>
                    <td>
                        <a href="https://www.youtube.com/watch?v=<?= $video->getHashId() ?>" target="_blank">
                            <?= $video->getTitle() ?>
                        </a>
                    </td>
                    <td>
                        <?= $video->getDescription() ?>
                    </td>
                    <td>
                        <?= $video->getLikesCount() ?>
                    </td>
                    <td>
                        <?= $video->getDislikesCount() ?>
                    </td>
                    <td>
                        <a href="/youtube/videos/delete?<?= YoutubeVideosFilter::ID ?>=<?= $video->getId() ?>"
                           target="_blank">Удалить</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <p>Информации о канале не найдено</p>
<?php } ?>