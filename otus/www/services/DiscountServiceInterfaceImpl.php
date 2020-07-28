<?php


namespace Services;


use Classes\Repositories\DiscountRepositoryInterface;

class DiscountServiceInterfaceImpl implements DiscountServiceInterface
{

    private $discountRepository;

    public function __construct(DiscountRepositoryInterface $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    public function apply(int $discountId, float $price)
    {
        $discount = $this->discountRepository->getDiscountById($discountId);
        if (!$discount) {
            return $price;
        }

        return $price - $discount->getValue();
    }
}
