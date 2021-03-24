<?php


namespace App\Model;


use App\Model\Builders\YoutubeChannelBuilder;
use App\Model\Interfaces\BuilderModelElasticsearchInterface;
use App\Model\Interfaces\ModelElasticsearchInterface;


class YoutubeChannel extends AbstractModel implements ModelElasticsearchInterface
{

    private int $ratio;

    /**
     * @return int
     */
    public function getRatio(): int
    {
        return $this->ratio;
    }

    /**
     * @param int $ratio
     */
    public function setRatio(int $ratio): void
    {
        $this->ratio = $ratio;
    }

    public function getSearchIndex(): string
    {
        return 'channel_index';
    }

    public function getSearchArray(): array
    {
        return get_object_vars($this);
    }


    public function getSearchFields(): array
    {
        return [
            'title^2',
            'description'
        ];
    }

    public function getBuilder(): BuilderModelElasticsearchInterface
    {
        return new YoutubeChannelBuilder();
    }
}
