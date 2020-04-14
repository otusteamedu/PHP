<?php


namespace Youtube;


use Youtube\DWH\Channel;
use Youtube\DWH\Dwh;
use Youtube\DWH\Video;

class YoutubeSpider
{
    const CAPTURE_OPT = [
        'chart' => 'mostPopular',
        'videoCategoryId' => '17',  //sport
        'maxResults' => 10,
        'regionCode' => 'ru'
    ];

    /** @var \Google_Service_YouTube */
    private $youtube = null;

    /** @var Channel[]  */
    private $channels = [];

    /** @var Video[]  */
    private $videos = [];

    public function __construct()
    {
        $cli = new \Google_Client();
        $cli->setDeveloperKey('AIzaSyBYii2jaeL02C1WrpJdyI3_ciF0oAjPVJQ');
        $this->youtube = new \Google_Service_YouTube($cli);
    }

    public function run()
    {
        $this->capture();
        $this->writeDB();
    }


    private function capture()
    {
        $videos = $this->youtube->videos->listVideos('snippet, statistics', self::CAPTURE_OPT);
        if (is_null($videos))
            return false;

        /** @var \Google_Service_YouTube_Video $item */
        foreach ($videos->getItems() as $item) {

            $this->appendToChannel($item);
            $this->appendToVideos($item);
        }
        return true;
    }

    /**
     * @param \Google_Service_YouTube_Video $item
     */
    private function appendToChannel($item)
    {
        $chID = $item->getSnippet()->channelId;
        if (isset($this->channels[$chID]))
            return;

        $channel = new Channel($chID);
        $channel->setTitle($item->getSnippet()->channelTitle);
        $this->channels[$chID] = $channel;
    }

    /**
     * @param \Google_Service_YouTube_Video $item
     */
    private function appendToVideos($item)
    {
        $videoID = $item->getId();
        if (isset($this->videos[$videoID]))
            return;

        $chID = $item->getSnippet()->channelId;
        $video = new Video($videoID, $chID);
        $video->setCountDislikes($item->getStatistics()->getDislikeCount());
        $video->setCountLikes($item->getStatistics()->getLikeCount());
        $this->videos[$videoID] = $video;
    }


    private function writeDB()
    {

        foreach ($this->channels as $channel)
            Dwh::getInst()->insertOrUpdate($channel);

        foreach ($this->videos as $video)
            Dwh::getInst()->insertOrUpdate($video);
    }


}