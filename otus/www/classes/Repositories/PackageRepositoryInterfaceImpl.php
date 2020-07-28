<?php

namespace Classes\Repositories;

use Classes\Models\Package;

class PackageRepositoryInterfaceImpl implements PackageRepositoryInterface
{

    private $dbClient;

    public function __construct($dbClient)
    {
        $this->dbClient = $dbClient;
    }

    public function getAllPackages(): array
    {
        // TODO: Implement getAllPackages() method.
    }

    public function getPackageByNumber(int $number):Package
    {
        // TODO: Implement getPackageByNumber() method.
    }

    public function getPackageById(int $id): Package
    {
        // TODO: Implement getPackageById() method.
    }

    public function getPackageWithOrderStatus(string $orderStatus): array
    {
        // TODO: Implement getPackageWithOrdersInStatus() method.
    }
}
