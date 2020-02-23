<?php

namespace App\Entities;

class CouponEntity extends BaseEntity
{
    protected $id;
    protected $discountCouponRub;
    protected $active;

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
    public function getDiscountCouponRub()
    {
        return $this->discountCouponRub;
    }

    /**
     * @param mixed $discountCouponRub
     */
    public function setDiscountCouponRub($discountCouponRub): void
    {
        $this->discountCouponRub = $discountCouponRub;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}