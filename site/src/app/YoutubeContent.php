<?php
namespace App;

use GuzzleHttp\Client;

class YoutubeContent
{

    private $httpClient;
    private const API_KEY = 'Your_api';


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
        $result = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/search', ['query' => $queryParams]);
        $videoList=json_decode($result->getBody());
        foreach ($videoList->items as $item) {
            if (isset($item->id->videoId)) {
                $videoid[] = $item->id->videoId;
            }
        }
        return $videoid ;

    }
    public function getVideosChannelInfo($videoDefaultId )
    {
        $result = $this->httpClient->request('GET','https://www.googleapis.com/youtube/v3/videos?id=' . $videoDefaultId . '&key=' . self::API_KEY . '&part=snippet,contentDetails,statistics,status');
        return json_decode($result->getBody());

    }
    public function getChannelInfo($idchannel)
    {

      $result = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/channels?id='.$idchannel.'&key='. self::API_KEY . '&part=snippet,contentDetails,statistics,status');
    return json_decode($result->getBody());
    }

}
