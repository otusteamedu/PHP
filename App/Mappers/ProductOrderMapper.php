<?php
namespace Ozycast\App\Mappers;

use Exception;
use Ozycast\App\Core\DTO;
use Ozycast\App\Core\Mapper;
use Ozycast\App\DTO\ProductOrder;

class ProductOrderMapper extends Mapper
{
    /**
     * @var string
     */
    protected $collectName = "product_order";

    protected static function getDTO() {
        return new ProductOrder();
    }

    /**
     * @param array|DTO $data
     * @return DTO
     * @throws Exception
     */
    public function insert($data): DTO
    {
        $model = is_array($data) ? new ProductOrder($data) : $data;

        if (!$model->getOrderId() || !$model->getProductId())
            throw new Exception('Properties empty');

        $this->connect->insert($this->collectName, [
            "product_id" => $model->getProductId(),
            "order_id" => $model->getOrderId(),
            "count" => $model->getCount(),
            "parcel_id" => $model->getParcelId(),
        ]);

        return $model;
    }

    /**
     * @param ProductOrder $model
     * @return ProductOrder
     * @throws Exception
     */
    public function update(ProductOrder $model): DTO
    {
        if (!$model->getOrderId() || !$model->getProductId())
            throw new Exception('Properties empty');

        $this->connect->update($this->collectName,
            ["product_id" => $model->getProductId(), "order_id" => $model->getOrderId()],
            [
                "product_id" => $model->getProductId(),
                "order_id" => $model->getOrderId(),
                "count" => $model->getCount(),
                "parcel_id" => $model->getParcelId(),
            ]
        );
        return $model;
    }

}