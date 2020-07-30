<?php

namespace Classes\Models;

class ProductPackagePivot extends AbstractActiveRecord
{
    protected $packageId;
    protected $productId;

    protected static $tableName = 'product_package_pivot';

    public function setProductId(int $productId)
    {
        $this->productId = $productId;
    }

    public function setPackageId(int $packageId)
    {
        $this->packageId = $packageId;
    }

}
