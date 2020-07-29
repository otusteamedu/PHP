<?php

namespace Classes\Repositories;

use Classes\Models\Package;

class PackageRepositoryInterfaceImpl implements PackageRepositoryInterface
{

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

    public function saveMany(array $packages): array
    {
        return [1, 2, 3]; // заглушка, возвращаются id сохраненных посылок
    }

    public function saveManyProductsPivots(array $productsPackages): array
    {
       return [1, 2, 3]; // заглушка, возвращаются id сохраненных связей продуктов и посылок
    }
}
