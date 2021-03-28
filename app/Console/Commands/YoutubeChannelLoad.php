<?php

namespace App\Console\Commands;

use App\Services\Channels\YoutubeChannelService;
use Illuminate\Console\Command;

class YoutubeChannelLoad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uchannel:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse random channel and their videos';

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
    public function handle(YoutubeChannelService $youtubeChannelService)
    {
        try {
            $this->info("Parsing...");
            $result = $youtubeChannelService->searchNew();
            $this->info("Channels parse! Saving...");
            $youtubeChannelService->saveNew($result);
            $this->info("Channels saved!");
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
