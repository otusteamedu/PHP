<?php


namespace Classes\Discounts;


use Classes\Models\Product;
use Classes\Models\ProductPackagePivot;
use Services\PackageServiceInterface;

class CdekDelivery implements DeliveryEntity
{
    const DEFAULT_DELIVERY_PRICE = 100;
    const MAX_PACKAGE_WEIGHT = 10;

    private $packageService;

    public function __construct(PackageServiceInterface $packageService)
    {
        $this->packageService = $packageService;
    }

    public function getPrice()
    {
       return self::DEFAULT_DELIVERY_PRICE;
    }

    public function setPackages(array $products)
    {
        $packagesCount = 1;
        /** @var Product $product */
        foreach ($products as $product) {
            if ($product->getWeight() > self::MAX_PACKAGE_WEIGHT) {
                $packagesCount++;
            }
        }

        $packagesIds = $this->packageService->getPackages($packagesCount);
        $productsPackages = $this->getMatchedProductsPackages($products, $packagesIds);
        $this->packageService->saveProductsPackages($productsPackages);
    }

    private function getMatchedProductsPackages (array $products, array $packagesIds)
    {
        $packageWeight = 0;
        $packageNumber = 0;

        $result = [];
        /** @var Product $product */
        $productPackagePivot = new ProductPackagePivot();
        foreach ($products as $key => $product) {
            $packageWeight+= $product->getWeight();
            if ($packageWeight > self::MAX_PACKAGE_WEIGHT) {
                $packageNumber++;
            }
            $productPackagePivot->setPackageId($packagesIds[$packageNumber]);
            $productPackagePivot->setProductId($product->getId());

            $result[] = $productPackagePivot;
        }
        return $result;
    }
}

