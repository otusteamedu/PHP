<?php


namespace App\package;


class Packager
{
    /** @var Package[] */
    private $packages = [];

    public function getPackage($packageID)
    {
        if (!isset($this->packages[$packageID]))
            $this->packages[$packageID] = new Package($packageID);

        return $this->packages[$packageID];
    }

    /**
     * @param Package $package
     */
    private function initPackage($package)
    {
        switch ($package->getId()) {
            case 1: $package->setType('A')->setCountUnits(1); break;
            case 2: $package->setType('B'); break;
        }
    }

}