<?php


namespace App\Services\Youtube;


use App\Services\Youtube\Repositories\Statistics\ViewChannelRepository;
use Illuminate\Support\Collection;

class ChannelStatisticService
{
    private ViewChannelRepository $viewChannelRepository;

    public function __construct(
        ViewChannelRepository $viewChannelRepository
    )
    {
        $this->viewChannelRepository = $viewChannelRepository;
    }

    /*public function getViewsCount(int $channelId): int
    {
        return $this->viewChannelRepository->getViewsCount($channelId);
    }

    public function getLikesCount(int $channelId): int
    {
        return $this->viewChannelRepository->getLikesCount($channelId);
    }

    public function getDislikesCount(int $channelId): int
    {
        return $this->viewChannelRepository->getDislikesCount($channelId);
    }*/

    public function getTopChannels(int $number): Collection
    {
        return $this->viewChannelRepository->getTopChannels($number);
    }


}
