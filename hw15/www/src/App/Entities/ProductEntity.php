<?php

namespace App\Entities;

class ProductEntity extends BaseEntity
{
    protected $id;
    protected $name;
    protected $priceRub;
    protected $size;
    protected $priceWithDiscount;
    protected $productDiscountId;
    protected $type;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPriceRub()
    {
        return $this->priceRub;
    }

    /**
     * @param mixed $priceRub
     */
    public function setPriceRub($priceRub): void
    {
        $this->priceRub = $priceRub;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getPriceWithDiscount()
    {
        return $this->priceWithDiscount;
    }

    /**
     * @param mixed $priceWithDiscount
     */
    public function setPriceWithDiscount($priceWithDiscount): void
    {
        $this->priceWithDiscount = $priceWithDiscount;
    }

    /**
     * @param mixed $priceWithDiscount
     */
    public function calculatePriceWithDiscount($priceWithDiscount): void
    {
        // calculate price with discount
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getProductDiscountId()
    {
        return $this->productDiscountId;
    }

    /**
     * @param mixed $productDiscountId
     */
    public function setProductDiscountId($productDiscountId): void
    {
        $this->productDiscountId = $productDiscountId;
    }
}