<?php


namespace App\Controllers;


use App\Core\Request;
use App\Entities\Channel;
use App\Repositories\Channel\ChannelRepository;
use App\Services\ServiceContainer\AppServiceContainer;
use App\Services\Statistics\ChannelStatistic;

class ChannelController extends BaseController
{
    private ChannelRepository $channelRepository;

    public function __construct()
    {
        $this->channelRepository = AppServiceContainer::getInstance()->resolve(ChannelRepository::class);
    }

    public function index(): void
    {
        $this->title = 'Channels';

        $this->content = $this->renderView('/pages/channels/index', [
            'channels' => (new ChannelStatistic())->getTopByLikesByDislikesQuotientSortDesc(10),
        ]);

        $this->viewResponse();
    }

    public function search(): void
    {
        $request = Request::getInstance();
        $query = $request->get('query', '');

        $this->title = 'Search channels';

        $this->content = $this->renderView('/pages/channels/index', [
            'channels' => $this->channelRepository->search($query)->sortByDesc(function (Channel $channel){
                return $channel->getVideosCount();
            }),
            'query' => $query,
        ]);

        $this->viewResponse();
    }
}