<?php

namespace VideoPlatform;

use Exception;
use VideoPlatform\interfaces\VideoSharingPlatformInterface;

class VideoPlatform
{
    private VideoSharingPlatformInterface $platform;

    public function __construct(VideoSharingPlatformInterface $platform)
    {
        $this->platform = $platform;
    }

    /**
     * начнет анализировать канал
     * @return void
     * @throws Exception
     */
    public function analyze() : void
    {
        $this->validateParam();
        $this->platform->analyze();
    }

    public function findById($id)
    {
        print_r($this->platform->getChannelById($id));
    }

    /**
     * @throws Exception
     */
    private function validateParam()
    {
        if (empty($_SERVER['argv'][1])) {
            throw new Exception("необходимо передать id каналов через запятую. Пример: php index.php id1,id2,id3 \n");
        }

        return true;
    }
}
