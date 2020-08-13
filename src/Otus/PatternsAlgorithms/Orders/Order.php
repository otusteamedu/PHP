<?php


namespace App\Otus\PatternsAlgorithms\Orders;


use App\Otus\PatternsAlgorithms\Discounts\Discount;
use App\Otus\PatternsAlgorithms\Products\Product;
use App\Otus\PatternsAlgorithms\Shipments\Shipment;
use App\Otus\PatternsAlgorithms\Users\Customer;

abstract class Order
{
    /**
     * Order name (overwritten by child classed);
     */
    protected $name;

    /**
     * Customer of the order.
     *
     * @var Customer
     */
    private $customer;

    /**
     * Products contained in the order.
     *
     * @var Product[]
     */
    private $products = [];

    /**
     * Discounts applied to the order total.
     *
     * @var Discount[]
     */
    private $discounts;

    /**
     * Order shipments.
     *
     * @var Shipment[]
     */
    private $shipments;


    /**
     * Order constructor.
     * Order must have at least one product.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->addProduct($product);
    }

    /**
     * Subtotal price of the order without discounts.
     *
     * @return float
     */
    public function subTotalPrice(): float
    {
        $subTotal = 0;
        foreach ($this->products as $product) {
            $subTotal += $product->getPrice();
        }
        return $subTotal;
    }

    /**
     * Final price of the order including discounts.
     */
    public function finalPrice()
    {
        return $this->subTotalPrice() - $this->totalDiscountInCurrency()-$this->totalShipmentPrice();
    }

    /**
     * Calculates total discount percentage for the order.
     */
    public function totalDiscountInPercentage()
    {
        $totalDiscount = 0;
        foreach ($this->discounts as $discount) {
            $totalDiscount += $discount->getPercentage();
        }
        return $totalDiscount;
    }

    public function totalDiscountInCurrency()
    {
        // if no discounts are applied, return subtotal
        if ($this->totalDiscountInPercentage() == 0) {
            return $this->subTotalPrice();
        }

        $totalDiscountInCurrency=$this->subTotalPrice() * $this->totalDiscountInPercentage();
        return round($totalDiscountInCurrency,2);
    }

    /**
     * Returns price of shipping the order packages.
     */
    public function totalShipmentPrice(){
        $totalShipmentPrice = 0;
        foreach ($this->shipments as $shipment ){
            $totalShipmentPrice+=$shipment->shipmentPrice();
        }
        return $totalShipmentPrice;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    /**
     * @return Discount[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    /**
     * @param Discount $discount
     */
    public function addDiscount(Discount $discount): void
    {
        // if total discount is more than 100% throw an error
        if (($this->totalDiscountInPercentage() + $discount->getPercentage()) > 1) {
            throw new \Exception('Cannot add another discount. Total discount will be more than 100%');
        }

        $this->discounts[] = $discount;
    }

    /**
     * @return \App\Otus\PatternsAlgorithms\Shipments\Shipment[]
     */
    public function getShipments()
    {
        return $this->shipments;
    }

    /**
     * @param Shipment $shipment
     */
    public function addShipment(Shipment $shipment)
    {
        $this->shipments[] = $shipment;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

}