<?php
namespace VideoPlatform;

use Exception;
use VideoPlatform\exceptions\AppException;
use VideoPlatform\interfaces\VideoSharingServiceInterface;
use VideoPlatform\services\YoutubeService;

class App
{
    private VideoSharingServiceInterface $videoPlatform;

    public function __construct()
    {
        $this->identifyService();
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        if (php_sapi_name() != 'cli') {
            throw new AppException('need to run in cli mode');
        }

        $platform = new VideoPlatform($this->videoPlatform);
        $platform->run();
    }

    /**
     * @throws Exception
     */
    private function identifyService()
    {
        switch ($_ENV['VIDEOPLATFORM']) {
            case YoutubeService::PLATFORM_NAME:
                $this->videoPlatform = new YoutubeService();
                break;
            default:
                throw new AppException('undefined video platform');
        }
    }
}
