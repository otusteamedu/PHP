<?php


namespace Classes\Repositories;


use Classes\Models\OrderClientPivot;

interface OrderClientRepositoryInterface
{
    public function save(OrderClientPivot $orderClientPivot);
}
