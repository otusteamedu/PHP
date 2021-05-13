<?php


namespace App\Command;

use App\Core\AbstractApplication;
use App\Core\AbstractController;
use App\Model\Youtube\Builder;


class YoutubeController extends AbstractController
{

    private Builder $youtubeBuilder;

    public function __construct(AbstractApplication $application)
    {
        parent::__construct($application);
        $this->youtubeBuilder = new Builder($this->app()->getConfig());
    }

    public function indexAction()
    {
        $storage = $this->youtubeBuilder->storage();
        $result = $storage->initIndexes();
        $this->log(print_r($result, true));
//        $this->log('Supported: statistics [channelId], top [number], analyze [channelId,[..]], spider');
    }

    public function statisticsAction()
    {
        $channelId = $_SERVER['argv'][2];
        $youtubeStatistics = $this->youtubeBuilder->statistics();
        $data = $youtubeStatistics->getSummary($channelId);
        $this->log(print_r($data, true));
    }

    public function topAction()
    {
        $number = 3;
        $youtubeStatistics = $this->youtubeBuilder->statistics();
        $data = $youtubeStatistics->getTop($number);
        $this->log(print_r($data, true));
    }

    public function analyzeAction()
    {
        $channelId = $_SERVER['argv'][2];
        if (!$channelId) {
            throw new \Exception('Channel is not set');
        }
        $analyzer = $this->youtubeBuilder->analyzer();
        $channelIds = explode(',', $channelId);
        $data = $analyzer->process($channelIds);
        $this->log(print_r(array_map(function ($ids, $key) {
            return $key . ' = '.count($ids);
        }, $data, array_keys($data)), true));
    }

    public function spiderAction()
    {
        throw new \Exception('Not implemented');
    }
}
