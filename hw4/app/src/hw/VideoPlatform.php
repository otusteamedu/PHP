<?php

namespace VideoPlatform;

use Exception;
use VideoPlatform\exceptions\AppException;
use VideoPlatform\interfaces\VideoSharingServiceInterface;

class VideoPlatform
{
    private const ANALYZE = 'analyze';
    private const STATISTICS = 'statistics';
    private const TOP = 'top';

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
    	if (!isset($_SERVER['argv'][1])){
		    throw new Exception("Передайте тип запроса! \n");
	    }

	    switch ($_SERVER['argv'][1]) {
		    case self::ANALYZE:
			    $result = $this->analyze();
			    break;
		    case self::STATISTICS:
			    $result = $this->getStatistics();
			    break;
		    case self::TOP:
			    $result = $this->getTopChannels();
			    break;
		    default:
			    throw new Exception("Передайте правильный тип запроса: analyze или statistics или top \n");
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
    private function validateParam(): void
    {
        if (empty($_SERVER['argv'][2])) {
            throw new AppException("Передайте id или Username каналов через запятую. Пример: php index.php analyze id1,name2 \n");
        }

    }
}
