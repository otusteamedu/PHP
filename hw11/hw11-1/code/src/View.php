<?php

namespace YoutubeApp;

class View
{
    private ChannelsModel $channelModel;
    private ChannelsStatistic $channelStatistic;
    private int $numberOfChanelForTop = 3;

    private array $topChannel;
    private array $allDataChannel;

    public function __construct()
    {
        $this->channelModel = new ChannelsModel();
        $this->channelStatistic = new ChannelsStatistic();
    }

    public function getTopChannel(): array
    {
        return $this->topChannel;
    }

    public function setTopChannel(): void
    {
        $this->topChannel = $this->channelStatistic->getTopChannelsStatistics($this->numberOfChanelForTop);
    }

    public function getAllDataChannel(): array
    {
        return $this->allDataChannel;
    }

    public function setAllDataChannel(): void
    {
        $this->allDataChannel = $this->channelModel->getAllData();
    }

    public function view(): void
    {
        $this->setAllDataChannel();
        $this->setTopChannel();
    }
}





