<?php


namespace Classes\Repositories;


use Classes\Models\OrderClientPivot;

class OrderClientRepositoryImpl implements OrderClientRepositoryInterface
{

    public function save(OrderClientPivot $orderClientPivot)
    {
        {
            try {
                $orderClientPivot->save();
            }
            catch (\Exception $exception) {
                //TODO реализовать логирование
                return false;
            }

            return true;
        }
    }
}
