<?php


namespace App\Otus\PatternsAlgorithms\Shipments;


class UPSShipment extends Shipment
{
    /**
     * @inheritdoc
     */
    protected $name = 'UPS';

    /**
     * @inheritdoc
     */
    protected $pricePerPackage = 2.99;
}