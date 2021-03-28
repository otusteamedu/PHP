<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Services\Channels\YoutubeChannelVideoService;
use Illuminate\Console\Command;

class YoutubeChannelUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uchannel:update {channel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load new videos for channel from youtube';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(YoutubeChannelVideoService $service)
    {
        try {
            $channel = Channel::find($this->argument('channel'));
            $this->info('Search ids...');
            $ids = $service->searchIdsByChannel($channel);
            $this->info('Got ids! Loading data...');
            $videos = $service->loadByIds($ids);
            $this->info('Got videos! Saving...');
            $service->save($channel, $videos);
            info('Complete!');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
