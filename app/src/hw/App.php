<?php
namespace VideoPlatform;

use Exception;
use VideoPlatform\exceptions\AppException;
use VideoPlatform\interfaces\VideoSharingServiceInterface;
use VideoPlatform\services\YoutubeService;

class App
{
    /**
     * @throws Exception
     */
    public function run()
    {
        if (php_sapi_name() !== 'cli') {
            throw new AppException('need to run in cli mode');
        }

        $platform = new VideoPlatform($this->getService());
        $platform->run();
    }

    /**
     * @throws Exception
     */
    private function getService(): VideoSharingServiceInterface
    {
        switch ($_ENV['VIDEOPLATFORM']) {
            case YoutubeService::PLATFORM_NAME:
                return new YoutubeService();
            default:
                throw new AppException('undefined video platform');
        }
    }
}
