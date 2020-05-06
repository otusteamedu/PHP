<?php
namespace Ozycast\App\Mappers;

use Exception;
use Ozycast\App\Core\Db;
use Ozycast\App\DTO\Channel;

class ChannelMapper
{
    /**
     * @var Db
     */
    private $connect = null;

    /**
     * @var string
     */
    private $collectName = "Channel";

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
     * @return Channel
     * @throws Exception
     */
    public function insert(array $data): Channel
    {
        $model = new Channel($data);

        if (!strlen($model->getId()) || !strlen($model->getTitle()))
            throw new Exception('Properties empty');

        $this->connect->insert($this->collectName, ["id" => $model->getId(), "title" => $model->getTitle()]);
        return $model;
    }

    /**
     * @param Channel $model
     * @return Channel
     * @throws Exception
     */
    public function update(Channel $model): Channel
    {
        if (!strlen($model->getId()) || !strlen($model->getTitle()))
            throw new Exception('Properties empty');

        $this->connect->update($this->collectName, ["id" => $model->getId()], ["id" => $model->getId(), "title" => $model->getTitle()]);
        return $model;
    }

    /**
     * @param array $params
     * @return array
     */
    public function findAll($params = []): array
    {
        $db = $this->connect->findAll($this->collectName, $params);
        return (new Channel())->serializeAll($db);
    }

    /**
     * @param $params
     * @return Channel|null
     */
    public function findOne($params): ?Channel
    {
        $db = $this->connect->findOne($this->collectName, $params);
        $model = $db ? (new Channel())->serialize($db) : null;
        return $model;
    }
}