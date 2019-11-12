<?php


 use App\YoutubeController;

 $first=new YoutubeController;

 $idchannel='UCms3ygkJEutytvLUS22VhtA';
 /*$first->saveChannel($idchannel);//созранение канала
 $first->saveVideosChannel($idchannel);//сохранения видео канала
 $first->deleteChannelAllVideos($idchannel)); //удаление одной записи канала и его видио
*/
/*foreach ($first->topChanelStatistics() as $value){
echo $value."</br>"; //топ каналов с разницей по лайкам и дизлайкам
 }
*/
//echo  $first->chanelAllVideoLikeStatistics($chanel);//статистика количество лайков повыбранному каналу
 
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
 
