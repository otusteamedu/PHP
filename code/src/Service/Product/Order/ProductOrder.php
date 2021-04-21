<?php


namespace App\Service\Product\Order;


use App\Observer\OrderObserverInterface;

class ProductOrder implements ProductOrderInterface, OrderSubjectInterface
{
    private int $number;
    private string $customerEmail;
    private string $productType;
    private ?array $productOptions;
    private string $state;
    private ?OrderObserverInterface $observer = null;

    /**
     * ProductOrder constructor.
     * @param string $customerEmail
     * @param string $productType
     * @param array|null $productOptions
     */
    public function __construct(string $customerEmail, string $productType, array $productOptions = null)
    {
        $this->number = rand(100, 100000);
        $this->customerEmail = $customerEmail;
        $this->productType = $productType;
        $this->productOptions = $productOptions;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
        if (null !== $this->observer) {
            $this->notify();
        }
    }

    public function getCustomerEmail(): string
    {
        return $this->customerEmail;
    }

    public function getProductType(): string
    {
        return $this->productType;
    }

    public function getProductOptions(): ?array
    {
        return $this->productOptions;
    }

    public function attach(OrderObserverInterface $observer): void
    {
        $this->observer = $observer;
    }

    public function detach(OrderObserverInterface $observer): void
    {
        $this->observer = null;
    }

    public function notify(): void
    {
        $this->observer->update($this);
    }

    public function getObserver(): OrderObserverInterface
    {
        return $this->observer;
    }
}
