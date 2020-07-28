<?php


namespace Classes\Repositories;


use Classes\Models\OrderClientPivot;

class OrderClientRepositoryInterfaceImpl implements OrderClientRepositoryInterface
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

    public function deleteAllRowsByOrderId(int $orderId)
    {
        //TODO реализовать поиск и удаление из бд по orderId
       return true;
    }

    public function deleteAllRowsByClientId(int $clientId)
    {
        //TODO реализовать поиск и удаление из бд по clientId
       return true;
    }
}
