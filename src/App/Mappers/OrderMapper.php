<?php
namespace Ozycast\App\Mappers;

use Exception;
use Ozycast\App\Core\DTO;
use Ozycast\App\Core\Mapper;
use Ozycast\App\DTO\Order;

class OrderMapper extends Mapper
{
    /**
     * @var string
     */
    protected $collectName = "orders";

    protected static function getDTO() {
        return new Order();
    }

    /**
     * @param array|DTO $data
     * @return DTO
     * @throws Exception
     */
    public function insert($data): DTO
    {
        $model = is_array($data) ? new Order($data) : $data;

        if (!$model->getClientId() || !$model->getSum())
            throw new Exception('Properties empty');

        $id = $this->connect->insert($this->collectName, [
            "client_id" => $model->getClientId(),
            "sum" => $model->getSum(),
            "status" => $model->getStatus(),
            "delivery_id" => $model->getDeliveryId(),
        ]);

        $model->setId($id);
        return $model;
    }

    /**
     * @param DTO $model
     * @return DTO
     * @throws Exception
     */
    public function update(DTO $model): DTO
    {
        if (!$model->getClientId() || !$model->getSum())
            throw new Exception('Properties empty');

        $this->connect->update($this->collectName, ["id" => $model->getId()], [
            "client_id" => $model->getClientId(),
            "sum" => $model->getSum(),
            "status" => $model->getStatus(),
            "delivery_id" => $model->getDeliveryId(),
        ]);

        return $model;
    }
}