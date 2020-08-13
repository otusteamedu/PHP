<?php


namespace App\Otus\PatternsAlgorithms\Shipments;

use App\Otus\PatternsAlgorithms\Package;

/**
 * Package shipment service.
 */
abstract class Shipment
{
    /**
     * Name of the shipment service.
     *
     * @var string
     */
    protected $name;

    /**
     * Price per package of the shipment service.
     *
     * @var float
     */
    protected $pricePerPackage = null;

    /**
     * Packages
     * @var Package[]
     */
    private $packages;

    /**
     * @return float
     */
    public function getPricePerPackage(): float
    {
        return $this->pricePerPackage;
    }

    /**
     * @param float $pricePerPackage
     */
    public function setPricePerPackage(float $pricePerPackage): void
    {
        $this->pricePerPackage = $pricePerPackage;
    }

    /**
     * @param Package $package
     */
    public function addPackage(Package $package)
    {
        $this->packages[] = $package;
    }

    /**
     * @return Package[]
     */
    public function getPackages(): array
    {
        return $this->packages;
    }

    /**
     * Total shipping price of the added packages.
     *
     * @return float
     */
    public function shipmentPrice()
    {
        return round(count($this->packages) * $this->getPricePerPackage(), 2);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Products in the shipment.
     */
    public function getProducts(){
        $products = [];
        foreach ($this->packages as $package){
            $products=array_merge($products, $package->getProducts());
        }
        return $products;
    }
}