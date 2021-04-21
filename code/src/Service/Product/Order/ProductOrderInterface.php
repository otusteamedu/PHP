<?php


namespace App\Service\Product\Order;



interface ProductOrderInterface extends OrderSubjectInterface
{
    public function getNumber(): int;
    public function getState(): string;
    public function setState(string $state): void;
    public function getCustomerEmail(): string;
    public function getProductType(): string;
    public function getProductOptions(): ?array;
}
