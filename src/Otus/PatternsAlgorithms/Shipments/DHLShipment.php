<?php


namespace App\Otus\PatternsAlgorithms\Shipments;


class DHLShipment extends Shipment
{
    /**
     * @inheritdoc
     */
    protected $name = 'DHL';

    /**
     * @inheritdoc
     */
    protected $pricePerPackage = 1.99;
}