<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\YoutubeChannelData;
use App\YoutubeVideoData;


class YoutubeContent implements YoutubeChannelData,YoutubeVideoData
{

    private $httpClient;
    private const API_KEY = 'AIzaSyDspmtrreJevOeoy7hYae77xl1Idy3kXRU';


    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function getVideosChannelIds($channelDefaultId)
    {

        $queryParams = [
            'order' => 'date',
            'part' => 'snippet',
            'channelId' => $channelDefaultId,
            'key' => self::API_KEY,
        ];

        try {
            $result = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/search', ['query' => $queryParams]);
        } catch (GuzzleException $e) {
            return  'Выброшено исключение: '. $e->getMessage(). "\n";
        }

        $videoList = json_decode($result->getBody());
        foreach ($videoList->items as $item) {
            if (isset($item->id->videoId)) {
                $videoId[] = $item->id->videoId;
            }
        }
        return $videoId;
    }
    public function getVideosChannelInfo($videoDefaultId)
    {
        try {
            $result = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/videos?id=' . $videoDefaultId . '&key=' . self::API_KEY . '&part=snippet,contentDetails,statistics,status');
        } catch (GuzzleException $e) {
            return  'Выброшено исключение: '. $e->getMessage(). "\n";

        }
        $result =json_decode($result->getBody());
        $youtubeVideo['id']=$result->items[0]->id;
        $youtubeVideo['channelId']=$result->items[0]->snippet->channelId;
        $youtubeVideo['description']=$result->items[0]->snippet->description;
        $youtubeVideo['publishedAt']=$result->items[0]->snippet->publishedAt;
        $youtubeVideo['title']=$result->items[0]->snippet->title;
        $youtubeVideo['categoryId']=$result->items[0]->snippet->categoryId;
        $youtubeVideo['privacyStatus']=$result->items[0]->status->privacyStatus;
        $youtubeVideo['publicStatsViewable']=$result->items[0]->status->publicStatsViewable;
        $youtubeVideo['viewCount']=$result->items[0]->statistics->viewCount;
        $youtubeVideo['likeCount']=$result->items[0]->statistics->likeCount;
        $youtubeVideo['dislikeCount']=$result->items[0]->statistics->dislikeCount;
        $youtubeVideo['favoriteCount']=$result->items[0]->statistics->favoriteCount;
        $youtubeVideo['commentCount']=$result->items[0]->statistics->commentCount;

        return $youtubeVideo;
    }


    public function getChannelInfo($idchannel)
    {


        try {
            $result = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/channels?id=' . $idchannel . '&key=' . self::API_KEY . '&part=snippet,contentDetails,statistics,status');
        } catch (GuzzleException $e) {
            return  'Выброшено исключение: '. $e->getMessage(). "\n";
        }
        $result = json_decode($result->getBody());
        $youtubeChannel['id'] = $result->items[0]->id;
        $youtubeChannel['title'] = $result->items[0]->snippet->title;
        $youtubeChannel['description'] = $result->items[0]->snippet->description;
        $youtubeChannel['publishedAt'] = $result->items[0]->snippet->publishedAt;
        $youtubeChannel['viewCount'] = $result->items[0]->statistics->viewCount;
        $youtubeChannel['commentCount'] = $result->items[0]->statistics->commentCount;
        $youtubeChannel['subscriberCount'] = $result->items[0]->statistics->subscriberCount;
        $youtubeChannel['hiddenSubscriberCount'] = $result->items[0]->statistics->hiddenSubscriberCount;
        $youtubeChannel['videoCount'] = $result->items[0]->statistics->videoCount;
        $youtubeChannel['privacyStatus'] = $result->items[0]->status->privacyStatus;

        return $youtubeChannel;
    }
}
