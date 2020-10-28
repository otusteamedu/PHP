<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FillYouTubeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youspider:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'YouTube spider. Fill database';

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
    public function handle()
    {
        $limit = 10;
        $success_try = 0;
        while ($success_try < $limit) {
            $this->line('Количество успешных траев: ' . $success_try);
            $channel_id = \App\Services\YouTube\YouTube::generateRandomChannelId();
            $ys = new \App\Services\YouTube\YouTube();
            $r = $ys->getChannelById($channel_id);
            if (empty($r)) {
                $this->line('Канал с id ' . $channel_id . ' не найден!');
            } else {
                $success_try++;
                foreach ($r as $channel) {
                    $this->line('Канал найден. Название канала: ' . $channel['channel_name']);
                    $videos = $ys->getYouTubeVideoByChannelId($channel_id);
                    $this->line('-- Количество видео на этом канале: ', count($videos));
                }
            }
        }
    }
}
