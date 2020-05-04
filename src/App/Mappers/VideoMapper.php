<?php
namespace Ozycast\App\Mappers;

use Exception;
use Ozycast\App\Core\Db;
use Ozycast\App\DTO\Video;

class VideoMapper
{
    /**
     * @var Db
     */
    private $connect = null;

    /**
     * @var string
     */
    private $collectName = "Video";

    /**
     * ChannelMapper constructor.
     * @param DB $db
     */
    public function __construct($db)
    {
        $this->connect = $db;
    }

    /**
     * @param array $data
     * @return Video
     * @throws Exception
     */
    public function insert(array $data): Video
    {
        $model = new Video($data);

        if (!strlen($model->getId()) || !strlen($model->getTitle()))
            throw new Exception('Properties empty');

        $this->connect->insert($this->collectName, [
            "id" => $model->getId(),
            "title" => $model->getTitle(),
            "channelId" => $model->getChannelId(),
            "likes" => $model->getLikes(),
            "dislikes" => $model->getDislikes(),
            "dateCheck" => $model->getDateCheck(),
        ]);
        return $model;
    }

    /**
     * @param Video $model
     * @return Video
     * @throws Exception
     */
    public function update(Video $model): Video
    {
        if (!strlen($model->getId()) || !strlen($model->getTitle()))
            throw new Exception('Properties empty');

        $this->connect->update($this->collectName, ["id" => $model->getId()], [
            "id" => $model->getId(),
            "title" => $model->getTitle(),
            "channelId" => $model->getChannelId(),
            "likes" => $model->getLikes(),
            "dislikes" => $model->getDislikes(),
            "dateCheck" => $model->getDateCheck(),
        ]);
        return $model;
    }

    /**
     * @param array $params
     * @return array
     */
    public function findAll($params = []): array
    {
        $db = $this->connect->findAll($this->collectName, $params);
        return (new Video())->serializeAll($db);
    }

    /**
     * @param $params
     * @return Video|null
     */
    public function findOne($params): ?Video
    {
        $db = $this->connect->findOne($this->collectName, $params);
        $model = $db ? (new Video())->serialize($db) : null;
        return $model;
    }

    public function aggregate(array $params): array
    {
        return $this->connect->aggregate($this->collectName, $params);
    }
}