<?php


namespace Classes\Discounts;


use Services\PackageServiceInterface;

class SdekDeliveryCreator extends AbstractDeliveriesCreator
{

    private $packageService;

    public function __construct(PackageServiceInterface $packageService)
    {
        $this->packageService = $packageService;
    }

    protected function getDelivery(): DeliveryEntity
    {
        return new CdekDelivery($this->packageService);
    }
}

