<?php


namespace Services;


use Classes\Models\Product;

interface PackageServiceInterface
{
    public function applyPackage(Product $product);
}
