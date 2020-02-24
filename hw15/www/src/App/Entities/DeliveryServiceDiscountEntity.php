<?php

namespace App\Entities;

class DeliveryServiceDiscountEntity extends BaseEntity
{
    protected $id;
    protected $discountRub;

    public function __construct(
        $discountRub
    )
    {
        $this->discountRub = $discountRub;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDiscountRub()
    {
        return $this->discountRub;
    }

    /**
     * @param mixed $discountRub
     */
    public function setDiscountRub($discountRub): void
    {
        $this->discountRub = $discountRub;
    }
}