<?php

namespace App;

use Config\Config;
use Exception;
use Grabbers\YoutubeGrabber;

/**
 * Class App
 *
 * @package App
 */
class App
{
    public const GRAB_CMD  = 'grab';
    public const STATS_CMD = 'stats';

    private const CHANNELS_LIST_CONFIG_PARAM = 'channels_list_path';

    private const ALLOWED_COMMANDS = [
        self::GRAB_CMD,
        self::STATS_CMD,
    ];

    private Config $config;

    public function __construct ()
    {
        $this->config = new Config();
    }

    /**
     * run the app
     */
    public function run (): void
    {
        $cmd = $_SERVER['argv'][1] ?? null;

        if (!isset($cmd) || !in_array($cmd, self::ALLOWED_COMMANDS)) {
            throw new Exception('Bad "cmd" param ' . $cmd);
        }

        if ($cmd === self::GRAB_CMD) {
            (new YoutubeGrabber())->grab($this->config->getItem(self::CHANNELS_LIST_CONFIG_PARAM));
        }
    }
}