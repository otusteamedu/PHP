<?php
use App\ReportYoutubeDataController;
use App\ReportYoutubeStatisticController;
use App\LazyLoad;
use App\YoutubeContent;


class App
{
    public static  function  init()
    {
        $YoutubeContent = new YoutubeContent;
        $LazyLoad = new LazyLoad;
        $YoutubeChannelMapper = $LazyLoad->getYoutubeChannelMapper();
        $YoutubeVideoMapper = $LazyLoad->getYoutubeVideoMapper();
        $YoutubeChannelsStatisticsMapper = $LazyLoad->getYoutubeChannelsStatisticsMapper();
        $YoutubeChannelStatisticsMapper = $LazyLoad->getYoutubeChannelStatisticsMapper();

        $idChannel = 'UCms3ygkJEutytvLUS22VhtA';
        $ReportYoutubeDataController = new ReportYoutubeDataController($YoutubeContent);
        $ReportYoutubeDataController->saveChannel($idChannel, $YoutubeChannelMapper);//сохранение канала
        $ReportYoutubeDataController->saveStatistic($idChannel, $YoutubeChannelMapper, $YoutubeVideoMapper, $YoutubeChannelStatisticsMapper); //сохранение статистики по каналу и его видео

        $ReportYoutubeDataController->deleteChannel($idChannel, $YoutubeChannelMapper); //удаление канала
        $ReportYoutubeDataController->saveVideosChannel($idChannel, $YoutubeVideoMapper); //сохранение всех видео канала
        $ReportYoutubeDataController->deleteChannelAllVideos($idChannel, $YoutubeChannelMapper, $YoutubeVideoMapper);//удаление всех видео канала
        $ReportYoutubeStatisticController = new ReportYoutubeStatisticController();
        $ReportYoutubeStatisticController->topChanelStatistics($YoutubeChannelsStatisticsMapper);//топ каналов с разницей по лайкам и дизлайкам

        $ReportYoutubeStatisticController->chanelAllVideoLikeStatistics($idChannel, $YoutubeChannelStatisticsMapper);//статистика количество лайков повыбранному каналу
    }
}
/*
function generateRandomString($length = 24)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}*/
// Echo the random string.
// Optionally, you can give it a desired string length.
//$string = generateRandomString();
//генерация рандомной строки
