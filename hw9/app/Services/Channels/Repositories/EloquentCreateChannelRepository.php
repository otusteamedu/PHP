<?php


namespace App\Services\Channels\Repositories;


use App\Models\Channel;
use App\Services\Channels\Repositories\Interfaces\WriteChannelInterface;
use App\Services\Youtube\YoutubeService;
use Illuminate\Support\Facades\Log;

class EloquentCreateChannelRepository implements WriteChannelInterface
{
    private YoutubeService $youtube_service;

    public function __construct(YoutubeService $youtube_service)
    {
        $this->youtube_service = $youtube_service;
    }

    public function createAndGet(string $channel_id): ?Channel
    {
        try {
            $channel_data = $this->youtube_service->getChannelData($channel_id);
            if (!empty($channel_data)) {
                return Channel::create($channel_data);
            }
        } catch (\Exception $e) {}
        Log::alert('FUCK');
        return null;
    }
}
