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
     * Subtotal price of all  products in the order.
     *
     * @var float
     */
    protected $productsSubtotal = 0;

    /**
     * Subtotal price of all product shipments.
     *
     * @var float
     */
    protected $shipmentSubtotal = 0;

    /**
     * Subtotal price before discounts.
     *
     * @var float
     */
    protected $subtotalBeforeDiscounts = 0;

    /**
     * Subtotal of all applied discounts.
     *
     * @var float
     */
    protected $discountSubtotal = 0;

    /**
     * Total price for the order.
     *
     * @var float
     */
    protected $finalPrice = 0;

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
     * Calculates subtotal price of all products in the order.
     *
     * @return float
     */
    protected function calculateProductsSubtotal()
    {
        foreach ($this->products as $product) {
            $this->productsSubtotal += $product->getPrice();
        }
    }

    /**
     * Calculates sum of all applied discounts.
     */
    protected function calculateDiscountSubtotal()
    {
        foreach ($this->discounts as $discount) {
            $this->discountSubtotal += $discount->getDiscountAmount($this);
        }
    }

    /**
     * Calculates shipment subtotal for all product shipments in the order.
     */
    protected function calculateShipmentSubtotal()
    {
        foreach ($this->shipments as $shipment) {
            $this->shipmentSubtotal += $shipment->shipmentPrice();
        }
    }

    /**
     * Return subtotal price before discounts are applied.
     *
     * @return float
     */
    protected function calculateSubTotalPriceBeforeDiscounts()
    {
        $this->subtotalBeforeDiscounts=$this->getProductsSubtotal() + $this->getShipmentSubtotal();
    }

    /**
     * Calculates final price of the order.
     */
    protected function calculateFinalPrice()
    {
        $this->finalPrice = $this->getSubtotalBeforeDiscounts() - $this->getDiscountSubtotal();
    }
    /**
     * Calculates order subtotals and total.
     */
    public function calculateTotals()
    {
        $this->calculateProductsSubtotal();
        $this->calculateShipmentSubtotal();
        $this->calculateSubTotalPriceBeforeDiscounts();
        $this->calculateDiscountSubtotal();
        $this->calculateFinalPrice();
    }

    //**************************************************************
    // Getters and setters below.
    //**************************************************************

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
        $this->discounts[] = $discount;
    }

    /**
     * @return Shipment[]
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
     * @return Customer
     */
    public function getCustomer()
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

    /**
     * @return float
     */
    public function getDiscountSubtotal()
    {
        return round($this->discountSubtotal,2);
    }


    /**
     * @return float
     */
    public function getProductsSubtotal()
    {
        return round($this->productsSubtotal,2);
    }


    /**
     * @return float
     */
    public function getShipmentSubtotal()
    {
        return round($this->shipmentSubtotal,2);
    }

    /**
     * @return float
     */
    public function getFinalPrice()
    {
        return round($this->finalPrice, 2);
    }


    /**
     * @return float
     */
    public function getSubtotalBeforeDiscounts()
    {
        return round($this->subtotalBeforeDiscounts,2);
    }

}