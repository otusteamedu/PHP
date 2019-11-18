<?php

require '../vendor/autoload.php';

$limit = $_POST["limit"] ?? null;
$apikey = $_POST["apikey"] ?? null;
$channel = $_POST["channel"] ?? null;

if (!$apikey && !$channel) {
    throw new Exception(sprintf('Нужен apikey и channel'));
}

$parser = new Ymdb\YoutubeParserV3($apikey);
$saver = new Ymdb\MongoClass();

$infoChannel = $parser->parseInfoChannel($channel);
$saver->updateInfoChannel($infoChannel);

$videos = 0;
do {
    $listVideo = $parser->parseListVideoByChannel($channel, $listVideo["nextPage"]);
    foreach ($listVideo["items"] as $video) {
        $InfoVideo = $parser->parseInfoVideo($video["videoId"]);
        $saver->updateInfoVideo($InfoVideo);
        $videos++;
        if ($limit && $videos >= $limit) {
            $break = true;
            break;
        }
    }
} while ($listVideo["nextPage"] && !$break);

printf('Обработал %d видио канала «%s»%s', $videos, $infoChannel["title"], PHP_EOL);
