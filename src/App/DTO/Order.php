<?php

namespace Ozycast\App\DTO;

use Ozycast\App\Core\DTO;

Class Order extends DTO
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $client_id;

    /**
     * @var float|int
     */
    private $sum;

    /**
     * @var int
     */
    private $status = 1;

    /**
     * @var int
     */
    private $delivery_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * @param int $client_id
     */
    public function setClientId(int $client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @return float|int
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getDeliveryId(): int
    {
        return $this->delivery_id;
    }

    /**
     * @param int $delivery_id
     */
    public function setDeliveryId(int $delivery_id)
    {
        $this->delivery_id = $delivery_id;
    }

    /**
     * Преобразовать объект в массив
     * @return array
     */
    public function toArray()
    {
        return [
            "id" => $this->id,
            "client_id" => $this->client_id,
            "sum" => $this->sum,
            "status" => $this->status,
            "delivery_id" => $this->delivery_id,
        ];
    }
}