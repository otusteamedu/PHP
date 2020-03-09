<?php

namespace App\Entity;

use App\EntityFilter\IEntityFilter;
use App\EntityFilter\ProductFilter;
use App\EntityInterface\IEntity;
use App\EntityInterface\IFetchAssoc;
use App\EntityInterface\IProduct;
use App\EntityRepository\ProductRepository;
use PDO;

class Product extends CommonEntity implements IProduct, IFetchAssoc
{
    private string $title = '';
    private float $price = .0;
    private float $weight = .0;

    /**
     * Product constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->repository = new ProductRepository($pdo);
    }

    /**
     * @inheritDoc
     */
    public static function getEntitiesByFilter(
        PDO $pdo,
        IEntityFilter $filter
    ): array {
        return ProductRepository::getEntitiesByFilter($pdo, $filter);
    }

    /**
     * @param PDO $pdo
     * @param int $id
     * @return Product
     */
    public static function getById(PDO $pdo, int $id): IEntity
    {
        return self::getEntitiesByFilter($pdo, new ProductFilter($id))[0] ??
               new Product($pdo);
    }

    /**
     * @inheritDoc
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    public function fetchToAssoc(): array
    {
        return [
            'title'  => $this->title,
            'price'  => $this->price,
            'weight' => $this->weight,
        ];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Product
     */
    public function setTitle(string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return Product
     */
    public function setWeight(float $weight): Product
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }
}