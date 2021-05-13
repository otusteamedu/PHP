<?php


namespace App\Model\Youtube;


use App\Api\ConfigInterface;
use App\Model\Service\Youtube;
use App\Model\Storage\YoutubeElasticSearch;

class Builder
{
    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function statistics(): Statistics
    {
        $storage = new YoutubeElasticSearch($this->config);
        return new Statistics($storage);
    }

    public function analyzer(): Analyzer
    {
        $storage = $this->storage();
        $service = new Youtube($this->config);
        $dataMapper = new DataMapper();
        return new Analyzer($storage, $service, $dataMapper);
    }

    public function storage(): YoutubeElasticSearch
    {
        return new YoutubeElasticSearch($this->config);
    }
}