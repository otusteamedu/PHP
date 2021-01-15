<?php

namespace VideoPlatform;

use Exception;
use VideoPlatform\interfaces\VideoSharingServiceInterface;

class VideoPlatform
{
    private VideoSharingServiceInterface $service;

    public function __construct(VideoSharingServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * начнет анализировать канал
     * @return void
     * @throws Exception
     */
    public function analyze() : void
    {
        $this->validateParam();
        $this->service->analyze();
    }

    public function findById($id)
    {
        print_r($this->service->getChannelById($id));
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
