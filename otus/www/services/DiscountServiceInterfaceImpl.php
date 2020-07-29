<?php


namespace Services;


use Classes\Discounts\LogisticDiscountCreator;
use Classes\Repositories\DiscountRepositoryInterface;

class DiscountServiceInterfaceImpl implements DiscountServiceInterface
{

    private $discountRepository;

    public function __construct(DiscountRepositoryInterface $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    public function apply(string $discountType, float $price)
    {
        $discount = $this->getDiscount($discountType);

        if (!$discount) {
            return $price;
        }

        if ($discount > $price) {
            return $price;
        }

        return $price - $discount;
    }

    private function getDiscount(string $discountType): float
    {
        $discount = null;

        switch ($discountType) {
            case 'logistic':
                $discount = new LogisticDiscountCreator();
                break;
        }

        if (!$discount) {
            throw new \RuntimeException('undefined discount class');
        }

        return (float) $discount->getDiscountValue();
    }
}
