<?php

namespace App\Http\Controllers;

use App\Services\Channels\ChannelService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private ChannelService $channel_service;

    public function __construct(ChannelService $channel_service)
    {
        $this->channel_service = $channel_service;
    }

    public function searchOrCreate(Request $request)
    {
        $search = $request->get('q', '');

        if (!$search) {
            return view('search.index', [
                'search' => $search
            ]);
        }

        $channel = $this->channel_service->search($search);

        if ($channel == NULL) {
            $channel = $this->channel_service->createAndGet($search);
        }

        return view('search.index', [
            'search' => $search,
            'channel' => $channel ? $channel->toPublic() : null
        ]);
    }

    public function getTop()
    {
        $channels = $this->channel_service->getTop();
        return view('search.index', [
            'channels' => $channels,
            'search' => ''
        ]);
    }
}
