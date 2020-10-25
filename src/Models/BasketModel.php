<?php

namespace App\Models;

use App\Core\RenderObserver\Observable;
use App\Core\Users\UsersFactory\UserFactoryInterface;

class BasketModel extends BaseModel
{
    private UserFactoryInterface $user;
    private string $dateCreate;
    private array $products;

    /**
     * BasketModel constructor.
     * @param UserFactoryInterface $user
     * @param array $products
     */
    public function __construct(UserFactoryInterface $user, array $products)
    {
        parent::__construct();
        $this->user = $user;
        $this->dateCreate = time();
        $this->products = $products;
    }

    public function addProduct(ProductModel $product, int $amount): void
    {
        if ($product->getAmount() > $amount) {
            $this->products[] = $product;
        }
    }

    /**
     * @return UserFactoryInterface
     */
    public function getUser(): UserFactoryInterface
    {
        return $this->user;
    }

    /**
     * @return int|string
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function update(Observable $object): void
    {
        // TODO: Implement update() method.
    }
}