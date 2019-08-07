<?php


$i = 0;

foreach ($objects as $data) {
    echo 'Канал ' . ++$i . PHP_EOL;
    echo 'Название ' . $data->name . PHP_EOL;
    echo 'Кол-во видео ' . $data->videos . PHP_EOL;
    echo 'Кол-во комментариев ' . $data->comments . PHP_EOL;
    echo 'Кол-во просмотров ' . $data->views . PHP_EOL;
    echo 'Кол-во подписчиков ' . $data->subscibers . PHP_EOL;
    echo '--------------------' . PHP_EOL;
}
