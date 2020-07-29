<?php


namespace Services;


use Classes\Models\Package;
use Classes\Models\ProductPackagePivot;
use Classes\Repositories\PackageRepositoryInterface;

class PackageServiceImpl implements PackageServiceInterface
{

    private $packageRepository;

    public function __construct
    (
        PackageRepositoryInterface $packageRepository
    )
    {
        $this->packageRepository = $packageRepository;
    }

    public function getPackages(int $packageCount): array
    {
        $batch = $this->getBatchNumber();

       $packages = [];
       for ($i = 0; $i < $packageCount; $i++) {
           $package = new Package();
           $package->setBatch($batch);
           $packages[] = $package;
       }
       return $this->packageRepository->saveMany($packages);
    }

    private function getBatchNumber()
    {
        $date = new \DateTime();
        /** @noinspection PhpUnhandledExceptionInspection */
        return random_int(100, 1000) + $date->getTimestamp();
    }

    public function saveProductsPackages(array $productsPackages): array
    {
       return $this->packageRepository->saveManyProductsPivots($productsPackages);
    }
}
