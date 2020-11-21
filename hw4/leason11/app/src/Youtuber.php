<?php
namespace app\src;
/**
 * Class Youtuber
 *
 * @author Petr Ivanov (petr.yrs@gmail.com)
 */
use Google\Client;
use Google_Service_YouTube;

class Youtuber
{
    /**
     * @var \Google\Client
     */
    private $api;
    /**
     * @var Google_Service_YouTube
     */
    private $youtube;


    public function __construct($API_KEY, $appName = 'test App')
    {
        $this->api = new \Google\Client();

        $this->api->setApplicationName($appName);

        $this->api->setDeveloperKey($API_KEY);

        // создаем сервис YouTube
        $this->youtube = new \Google_Service_YouTube($this->api);

    }


    /**
     * Получение информации о канале по ID
     * @param string $channelId
     *
     * @return Google_Service_YouTube_Channel[]
     */
    public function getChannelInfo($channelId)
    {
        echo "channel info for $channelId \n";
        $channels = $this->youtube->channels->listChannels('snippet', ['id' => $channelId]);
        print_r($channels);
        return $channels['items'];
    }

    public function getChannelVideos($channelId){
        echo "channel video $channelId \n";
        return $this->youtube->search->listSearch('snippet,id', ['channelId'=>$channelId, 'type'=>'video']);
    }

    public function getVideoRating($id){
        echo "get video rating $id \n";
        $data = $this->youtube->videos->getRating($id);
        return $data;
    }
}