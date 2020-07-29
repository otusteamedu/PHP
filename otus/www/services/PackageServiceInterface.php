<?php


namespace Services;


interface PackageServiceInterface
{
    public function getPackages(int $packageCount): array;
    public function saveProductsPackages(array $productsPackages): array;
}
