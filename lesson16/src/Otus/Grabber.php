<?php

namespace Otus;

class Grabber
{
    protected  $api;

    public function __construct()
    {
        $this->api = YouTubeApi::getInstance();
    }

    public function grabChannel(string $id)
    {
        $channel = Channel::findOneById(['_id'=>$id]);
        if (!$channel) {
            $channel = new Channel();
        }
        $apiChannel = $this->api->getChannelInfoById($id);
        $channel->fromYouTubeData($apiChannel);
        $channel->save();
        $this->grabVideosByPlaylist($channel->getUploads());
    }

    public function grabVideosByPlaylist(string $playlistId, $part = ['snippet'], $pageToken = null, $limit = 10)
    {
        $apiVideoList = $this->api->getPlaylistInfo($playlistId, $part, $pageToken, $limit);
        $ids = [];
        foreach ($apiVideoList->items as $item) {
            $ids[] = $item->snippet->resourceId->videoId;
        }
        if (count($ids)>0) {
            $this->grabVideosByIds(implode(',',$ids));
        }
        $nextPage = isset($apiVideoList->nextPageToken) ? $apiVideoList->nextPageToken : null;
        if ($nextPage) {
            $this->grabVideosByPlaylist($playlistId, $part, $nextPage, $limit);
        }
    }

    public function grabVideosByIds($ids)
    {
        $apiVideos = $this->api->getVideosInfo($ids);
        foreach ($apiVideos as $item) {
            $video = new Video();
            $video->fromYouTubeData($item);
            $video->save();
        }
    }

    public function getRandomChannelId()
    {
        $channelId = '';
        while (!$channelId) {
            $word = $this->getDigits();
            $randVideos = $this->api->searchVideoByWorld($word);
            if(count($randVideos) == 0) {
                continue;
            }
            $channelId = $randVideos[array_rand($randVideos)]->snippet->channelId;
        }
        return $channelId;
    }

    private function getDigits()
    {
        $lang = mt_rand(0,1);
        $digits = '';
        for ($i=0;$i<3;$i++) {
            if ($lang) {
                $digits .= chr(mt_rand(ord('а'), ord('я')));
            } else {
                $digits .= chr(mt_rand(ord('a'), ord('z')));
            }
        }
        return $digits;
    }
}