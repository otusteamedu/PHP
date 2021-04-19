<?php


namespace Otushw\Storage;

use Otushw\DTOs\OrderDTO;
use Otushw\Models\Order;

interface MapperInterface
{
    public function findById(int $id): ?Order;
    public function insert(OrderDTO $order): Order;
    public function update(Order $order): bool;
    public function delete(int $orderID): bool;
}