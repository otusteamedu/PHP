<?php

namespace App\Services\YouTube;

use App\Models\YouTubeChannel;
use App\Models\YouTubeVideo;
use Illuminate\Support\Str;

class YouTube {

    private \App\Services\Api\YouTube $youtube;

    public function __construct() {
        $this->youtube = new \App\Services\Api\YouTube();
    }

    /**
     * Получает информацию о канале.
     * Сначала происходит поиск базе, если в базе нет такого канала - попытка вытянуть по API и сохранить.
     *
     * @param string $url Ссылка на канал
     *
     * @return array
     */
    public function getYouTubeChannelInformationByUrl(string $url) {
        $channels = YouTubeChannel::where('custom_url', $url)->get();

        if ($channels->isEmpty()) {
            $channelName = explode('/', $url);
            $channelName = array_pop($channelName);
            $result = $this->getChannelByName($channelName);
        } else {
            $result = [];
            foreach ($channels as $channel) {
                $result[$channel->channel_id] = [
                    'channel_id'   => $channel->channel_id,
                    'channel_name' => $channel->name,
                    'custom_url'   => $channel->custom_url,
                ];
            }
        }

        return $result;
    }

    /**
     * Возвращает массив вида:
     * [
     *      channel_name_1 => [
     *          \Models\YouTubeVideo(),
     *          \Models\YouTubeVideo(),
     *          ...
     *      ],
     *      channel_name_2 => [..]
     *      ...
     * ]
     *
     * @param string $url url youtube канала
     *
     * @return array
     */
    public function getYouTubeVideoByChannelUrl(string $url) {
        $channels = $this->getYouTubeChannelInformationByUrl($url);

        if (!$channels) return [];

        return $this->prepareVideo($channels);
    }

    public function getYouTubeVideoByChannelId(string $id) {
        $channels = $this->getChannelById($id);

        return $this->prepareVideo($channels);
    }

    public function getChannelByName(string $name) {
        $result = $this->youtube->getChannelInfo(['name' => $name]);
        $this->storeChannelIfNotExist($result);

        return $result;
    }

    public function getChannelById(string $id) {
        $result = $this->youtube->getChannelInfo(['id' => $id]);
        $this->storeChannelIfNotExist($result);

        return $result;
    }

    private function storeChannelIfNotExist(array $channels) {
        foreach ($channels as $channel) {
            $youtubeChannel = YouTubeChannel::where('channel_id', $channel['channel_id'])
                ->first();

            if (empty($youtubeChannel)) {
                $youtubeChannel             = new YouTubeChannel();
                $youtubeChannel->name       = $channel['channel_name'];
                $youtubeChannel->channel_id = $channel['channel_id'];
                $youtubeChannel->custom_url = $channel['custom_url'];
                $youtubeChannel->save();
            }
        }
    }

    private function storeVideoIfNotExist(array $videos, string $channel_id) {

        $videosInBase = YouTubeVideo::whereIn('video_id', array_keys($videos))
            ->get();
        foreach ($videosInBase as $videoInBase) {
            if (isset($videos[$videoInBase->video_id])) {
                $video                       = $videos[$videoInBase->video_id];
                $videoInBase->title          = $video['title'];
                $videoInBase->likes_count    = $video['likes'];
                $videoInBase->dislikes_count = $video['dislikes'];
                $videoInBase->views_count    = $video['views'];
                $videoInBase->save();
                unset($videos[$videoInBase->video_id]);
            }
        }

        foreach ($videos as $video_id => $video) {
            $videoInBase                 = new YouTubeVideo();
            $videoInBase->title          = $video['title'];
            $videoInBase->likes_count    = $video['likes'];
            $videoInBase->dislikes_count = $video['dislikes'];
            $videoInBase->views_count    = $video['views'];
            $videoInBase->channel_id     = $channel_id;
            $videoInBase->video_id       = $video_id;
            $videoInBase->save();
            $arrayVideosModels[] = $videoInBase;
        }
    }

    private function getVideoModels($videos) {
        $r = YouTubeVideo::whereIn('video_id', array_keys($videos))
            ->get();
        $d = [];
        foreach ($r as $v) {
            $d[] = $v;
        }
        return $d;
    }

    private function prepareVideo($channels) {
        $channelVideos = [];
        foreach ($channels as $channel_id => $channel) {
            $channelVideos[] = [
                'channel_id'   => $channel_id,
                'channel_name' => $channel['channel_name'],
                'videos_id'    => $this->youtube->getChannelVideosById($channel_id),
            ];
        }
        $videosStatistics = [];

        foreach ($channelVideos as $channelVideo) {
            $videos = $this->youtube->getVideoByIds($channelVideo['videos_id']);
            $this->storeVideoIfNotExist($videos, $channelVideo['channel_id']);
            $arrayVideosModels = $this->getVideoModels($videos);

            $videosStatistics[$channelVideo['channel_name']] = $arrayVideosModels;
        }

        return $videosStatistics;
    }

    public static function generateRandomChannelId() {
        $spec =  ['-', '_'];

        $count = random_int(1, 24);
        $id = Str::random($count);

        while (strlen($id) < 24) {

            $tmp = random_int(1, 24-strlen($id));

            if (strlen($id) + $tmp > 24) {
                continue;
            } else if (strlen($id) + $tmp <= 23) {
                shuffle($spec);
                $id .= $spec[random_int(0,1)];
                $count += $tmp;
                $id .= Str::random($tmp);
            } else {
                $id .= Str::random($tmp);
                break;
            }

            if ($count >= 24) break;
        }
        return $id;
    }

}
