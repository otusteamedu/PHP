<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;
use Ozycast\App\DTO\Parcel;
use Ozycast\App\Mappers\ParcelMapper;
use Ozycast\App\Mappers\ProductMapper;
use Ozycast\App\Mappers\ProductOrderMapper;

class OrderParcel
{
    /**
     * @var Parcel
     */
    public $parcel;

    // Максимальный вес посылки
    CONST MAX_SIZE_PARCEL = 70;

    public function __construct(Order $orderModel)
    {
        foreach ($orderModel->productOrder as $productOrder) {
            $this->sort();

            $product = (new ProductMapper(App::getDb()))->findOne(['id' => $productOrder->getProductId()]);

            $this->parcel->setSize($productOrder->getCount() * $product->getSize() + $this->parcel->getSize());
            $this->parcel->setWeight($productOrder->getCount() * $product->getWeight() + $this->parcel->getWeight());

            $this->save();

            $productOrder->setParcelId($this->parcel->getId());
            (new ProductOrderMapper(App::getDb()))->update($productOrder);
        }

        return $this;
    }

    /**
     * Сортирует товары по посылкам
     */
    public function sort()
    {
        if (!$this->parcel || $this->parcel->getSize() >= self::MAX_SIZE_PARCEL)
            $this->parcel = new Parcel();
    }

    /**
     * сохраняем посылку в БД
     * @throws \Exception
     */
    public function save()
    {
        if (!$this->parcel->getId()) {
            (new ParcelMapper(App::getDb()))->insert($this->parcel);
        } else {
            (new ParcelMapper(App::getDb()))->update($this->parcel);
        }
    }
}