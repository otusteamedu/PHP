<?php

namespace App;

use App\Config\Config;
use App\Grabbers\YoutubeGrabber;
use App\Log\Log;
use App\Models\ChannelMapper;
use Monolog\Logger;

class App
{
    public const GRAB_CMD  = 'grab';
    public const STATS_CMD = 'stats';

    /**
     * run the app
     */
    public function run (): void
    {
        $config = Config::getInstance();

        $allowedCommands = $config->getItem('allowed_commands');

        $cmd = $_SERVER['argv'][1] ?? null;

        if (!isset($cmd) || !in_array($cmd, $allowedCommands)) {
            Log::getInstance()->addRecord('Bad "cmd" param ' . $cmd, Logger::ERROR);
        }

        if ($cmd === self::GRAB_CMD) {
            $channelsList = $config->getItem('channels_for_grabbing_list');

            (new YoutubeGrabber())->grab($channelsList);
        }
        else if ($cmd === self::STATS_CMD) {
            Log::getInstance()->addRecord('CALCULATING STATS');

            $channels = ChannelMapper::getAll();

            foreach ($channels as $channel) {
                echo json_encode(ChannelMapper::getStats($channel->id)) . PHP_EOL;
            }
        }
    }
}