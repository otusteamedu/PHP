<?php

require '../vendor/autoload.php';

$channel = $_POST["channel"] ?? null;
$videoid = $_POST["videoid"] ?? null;

if (!$channel && !$videoid) {
    throw new Exception(sprintf('Нужен channel или videoid'));
}

$remover = new Ymdb\MongoClass();

if ($channel) {
    $result = $remover->removeChannel($channel);
    printf("Удалил %d видео%s", $result, PHP_EOL);
}

if ($videoid) {
    $result = $remover->removeVideo($videoid);
    printf("Удалил %d видео%s", $result, PHP_EOL);
}
