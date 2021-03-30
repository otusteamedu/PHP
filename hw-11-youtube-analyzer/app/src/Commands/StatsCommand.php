<?php

namespace App\Commands;

use App\Log\Log;
use App\Models\ChannelMapper;

class StatsCommand implements Command
{
    public function execute (): string
    {
        Log::getInstance()->addRecord('CALCULATING STATS');

        $channels = ChannelMapper::getAll();

        $result = [];

        foreach ($channels as $channel) {
            $result[] = ChannelMapper::getStats($channel->id);
        }

        return json_encode($result);
    }
}