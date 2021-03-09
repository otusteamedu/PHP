<?php

namespace Otus\Payment;

use Monolog\Logger;
use Otus\Exceptions\PaymentException;
use Otus\Repository\OrderRepository;

class PaymentService
{
    const WITH_ERROR = false; //чист для теста
    private array $requestData;

    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * @return bool
     * @throws PaymentException
     */
    public function pay(): bool
    {
        //имитация оплаты
        sleep(1);

        if (self::WITH_ERROR){
            throw new PaymentException('payment service error,', Logger::CRITICAL);
        }

        $this->requestData['additional_data'] = ['data' => 'data'];

        $orderRepository = new OrderRepository($this->requestData);
        $orderRepository->save();

        return true;
    }
}