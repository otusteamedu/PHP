<?php

namespace VideoPlatform;

use Exception;
use VideoPlatform\interfaces\VideoSharingServiceInterface;
use VideoPlatform\services\YoutubeService;

class App
{
    private VideoSharingServiceInterface $videoPlatform;

	/**
	 * @throws Exception
	 */
	public function __construct()
    {
	    $this->videoPlatform = new YoutubeService();
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        $platform = new VideoPlatform($this->videoPlatform);
        $platform->run();
    }
}
