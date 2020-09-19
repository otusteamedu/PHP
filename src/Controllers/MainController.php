<?php

namespace Controllers;

use Exceptions\RestClientException;

class MainController
{
    protected $es;

    public function __construct()
    {
        $this->es = new ElasticSearchController();
    }


    public function getSaveYoutubeData()
    {
        return $this->es->searchDocument([
            'index' => 'youtube'
        ]);
    }

    /**
     * @param string $nameChannel
     * @return bool
     * @throws RestClientException
     */
    public function writeYoutubeData(string $nameChannel)
    {
        $youtubeChannelModel = (new YouTubeAPIController())->getData($nameChannel);
        if ($youtubeChannelModel !== false) {
            $youtubeChannelModel->save();
            return true;
        }
        return false;
    }
}
