<?php

require '../vendor/autoload.php';

use MathieuViossat\Util\ArrayToTextTable;
use Otus\Lessons\Lesson4\DeclinerNumbers;

$metrika = new Ymdb\MetrikaClass();
$decliner = new DeclinerNumbers;

$metrika
    ->setChannelCount()
    ->setVideoCount()
    ->setLikeCount()
    ->setDislikeCount()
    ->setArrChannels();

if (!$metrika->channelCount) {
    echo "Еще нечего считать :(" . PHP_EOL;
    exit;
}

$total = "Всего в базе:" . PHP_EOL;
$total .= sprintf('%d %s%s',
    $metrika->channelCount,
    $decliner->declinNumber($metrika->channelCount, "канал", "канала", "каналов"),
    PHP_EOL);
$total .= sprintf('%d видео%s',
    $metrika->videoCount,
    PHP_EOL);
$total .= sprintf('%d %s%s',
    $metrika->likeCount,
    $decliner->declinNumber($metrika->likeCount, "лайк", "лайка", "лайков"),
    PHP_EOL);
$total .= sprintf('%d %s%s',
    $metrika->dislikeCount,
    $decliner->declinNumber($metrika->dislikeCount, "дизлайк", "дизлайка", "дизлайков"),
    PHP_EOL);
$total .= PHP_EOL;

$total .= "Из них:" . PHP_EOL;
$renderer = new ArrayToTextTable($metrika->arrChannels);
$total .= $renderer->getTable();

$total .= PHP_EOL;
$dislikest = $metrika->arrChannels[0];
foreach ($metrika->arrChannels as $obj) {
    $num = $obj["channelRate"];
    if ($num < $dislikest["channelRate"]) {
        $dislikest = $obj;
    }
}
$total .= "Самый дизлайканый канал" . PHP_EOL;
$total .= sprintf('«%s» с результатом %s%s', $dislikest['channelTitle'], $dislikest['channelRate'], PHP_EOL);

$total .= PHP_EOL;
$likest = $metrika->arrChannels[0];
foreach ($metrika->arrChannels as $obj) {
    $num = $obj["channelRate"];
    if ($num > $likest["channelRate"]) {
        $likest = $obj;
    }
}
$total .= "Самый лайканый канал" . PHP_EOL;
$total .= sprintf('«%s» с результатом %s%s', $likest['channelTitle'], $likest['channelRate'], PHP_EOL);

echo $total;
