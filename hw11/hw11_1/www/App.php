<?php

use \App\YouTubeController;

$channelNames= ['whoismitski', 'holograms', 'Kdimb', 'scottrobertsondesign', 'SonicYouthTV', 'thenationalofficial', 'bjorkdotcom'];
$topCount = 4;

$youTubeControler = new YouTubeController();

foreach ($channelNames as $channelName) {
    // сохранение данных канала
//    $youTubeControler->saveChannel($channelName);
    // сохранение данных видео канала
//    $youTubeControler->saveVideosChannel($channelName);
    // Статистика по всем видео канала
    print_r($youTubeControler->chanelAllVideoStatistic($channelName));
}
// Топ $topCount каналов
print_r($youTubeControler->topChanelStatistic($topCount));
