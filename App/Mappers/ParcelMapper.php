<?php
namespace Ozycast\App\Mappers;

use Exception;
use Ozycast\App\Core\DTO;
use Ozycast\App\Core\Mapper;
use Ozycast\App\DTO\Parcel;

class ParcelMapper extends Mapper
{
    /**
     * @var string
     */
    protected $collectName = "parcels";

    protected static function getDTO() {
        return new Parcel();
    }

    /**
     * @param array $data
     * @return DTO
     * @throws Exception
     */
    public function insert($data): DTO
    {
        $model = is_array($data) ? new Parcel($data) : $data;

        if (!$model->getWeight() || !$model->getSize())
            throw new Exception('Properties empty');

        $id = $this->connect->insert($this->collectName, [
            "code" => $model->getCode(),
            "size" => $model->getSize(),
            "weight" => $model->getWeight(),
        ]);

        $model->setId($id);
        return $model;
    }

    /**
     * @param Parcel $model
     * @return Parcel
     * @throws Exception
     */
    public function update(Parcel $model): DTO
    {
        if (!$model->getWeight() || !$model->getSize())
            throw new Exception('Properties empty');

        $this->connect->update($this->collectName, ["id" => $model->getId()], [
            "code" => $model->getCode(),
            "size" => $model->getSize(),
            "weight" => $model->getWeight(),
        ]);

        return $model;
    }
//
}