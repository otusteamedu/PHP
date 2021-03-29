<?php

namespace App\Services\Statistics;

use App\Entities\Channel;
use App\Repositories\Channel\ChannelRepository;
use App\Services\ServiceContainer\AppServiceContainer;
use Illuminate\Support\Collection;

class ChannelStatistic
{
    private ChannelRepository $channelRepository;

    public function __construct()
    {
        $this->channelRepository = AppServiceContainer::getInstance()->resolve(ChannelRepository::class);
    }

    public function getAllWithCountVideoLikesAndDislikes() : Collection
    {
        return $this->channelRepository->withVideoStatistics()
            ->getAll();
    }

    public function getTopByLikesByDislikesQuotientSortDesc($count = 10) : Collection
    {
        return $this->channelRepository->withVideoStatistics()
            ->getAll()
            ->sortByDesc(function (Channel $channel){
                return $channel->getVideoLikesByDislikesQuotient();
            })
            ->values()
            ->take($count);
    }
}