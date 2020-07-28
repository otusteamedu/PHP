<?php

namespace Classes\Repositories;

use Classes\Models\Package;

interface PackageRepositoryInterface
{

    public function getAllPackages() : array;

    public function getPackageByNumber(int $number): Package;

    public function getPackageById(int $id): Package;

    public function getPackageWithOrderStatus(string $orderStatus): array;

}
