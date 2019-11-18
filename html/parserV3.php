<?php

require '../vendor/autoload.php';

// получаем пост
$limit = $_POST["limit"] ?? null;
$apikey = $_POST["apikey"] ?? null;
$channel = $_POST["channel"] ?? null;

// без ключа и ид канала работать не сможем
if (!$apikey && !$channel) {
    throw new Exception(sprintf('Нужен apikey и channel'));
}

// подключаемся к базе и к ютубу
$parser = new Ymdb\YoutubeParserV3($apikey);
$saver = new Ymdb\MongoClass();

// получаем информацию о канале и сохраняем в базу
$infoChannel = $parser->parseInfoChannel($channel);
$saver->updateInfoChannel($infoChannel);

// постранично получаем список всех видео на канале
// миниму одну страницу надо обработать, поэтому do while
$videos = 0;
do {
    // если $listVideo["nextPage"] пустой, получим первую страницу, иначе ту, которая в нем указана
    $listVideo = $parser->parseListVideoByChannel($channel, $listVideo["nextPage"]);

    // берем каждое видео со страницы, и обрабатываем
    foreach ($listVideo["items"] as $video) {
        // получаем подробную информацию о видео
        $InfoVideo = $parser->parseInfoVideo($video["videoId"]);
        // сохраняем в базу
        $saver->updateInfoVideo($InfoVideo);

        $videos++;
        // добавил учет лимита на общее кол-во видео,
        // можно без этого, но тогда квота быстро сгорит на каком нибудь большем канале.
        if ($limit && $videos >= $limit) {
            $break = true; // чтобы выйти из while сразу после выхода из foreach
            break; // выходим из foreach
        }
    }
// слегка извращенный выход
    // выходим если нет $listVideo["nextPage"]
    // или если достигли лимита
} while ($listVideo["nextPage"] && !$break);

printf('Обработал %d видио канала «%s»%s', $videos, $infoChannel["title"], PHP_EOL);
