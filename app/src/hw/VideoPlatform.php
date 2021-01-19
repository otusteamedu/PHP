<?php

namespace VideoPlatform;

use Exception;
use VideoPlatform\exceptions\AppException;
use VideoPlatform\interfaces\VideoSharingServiceInterface;

class VideoPlatform
{
    const ANALYZE = 'analyze';
    const STATISTICS = 'statistics';
    const TOP_N = 'top_n';

    private VideoSharingServiceInterface $service;

    public function __construct(VideoSharingServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * анализ канала
     *  - данные о канале
     *  - данные о видео этого канала
     * сохраняет в noSql хранилище
     *
     * @return mixed
     * @throws Exception
     */
    public function analyze()
    {
        $this->validateParam();
        return $this->service->analyze();
    }

    /**
     * Вернет статистику канала. А именно:
     * [
     *  'totalLikes' => 123,
     *  'totalDislikes' => 12,
     * ]
     * @return mixed
     * @throws Exception
     */
    public function getStatistics()
    {
        $this->validateParam();
        return $this->service->getStatistics();
    }

    /**
     * Топ N каналов по соотношению totalLikes/Dislikes
     * N - передается как параметр и находится в $_SERVER[argv]
     *
     * @return mixed
     */
    public function getTopChannels()
    {
        return $this->service->getTopChannels();
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        switch ($_SERVER['argv'][1]) {
            case self::ANALYZE:
                $result = $this->analyze();
                break;
            case self::STATISTICS:
                $result = $this->getStatistics();
                break;
            case self::TOP_N:
                $result = $this->getTopChannels();
                break;
            default:
                throw new Exception('необходимо передать тип: php index.php analyze или statistics');
        }

        print_r($result);
    }

    /**
     * @param $id
     * @return
     */
    public function findChannelById($id)
    {
        return $this->service->findChannelById($id);
    }

    /**
     * @throws Exception
     */
    private function validateParam()
    {
        if (empty($_SERVER['argv'][2])) {
            throw new AppException("необходимо передать id каналов через запятую. Пример: php index.php analyze|statistics id1,id2,id3 \n");
        }

        return true;
    }
}
