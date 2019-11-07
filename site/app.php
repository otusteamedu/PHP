<?php

use App\ModelChannel;
use App\Statistics;






$second = new Statistics;
$chanel='Chanel_ID';
//echo $second->chanelAllVideoLikeStatistics($chanel);//статистика количество лайков повыбранному каналу
//echo $second->topChanelStatistics();//топ каналов с разницей по лайкам и дизлайкам

$first = new ModelChannel;

//$first->saveChannel($chanel);
//$first->deletChannel($chanel);//удаление канала
function generateRandomString($length = 24) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
// Echo the random string.
// Optionally, you can give it a desired string length.
$string=generateRandomString();
//генерация рандомной строки
 

