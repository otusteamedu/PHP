<?php

namespace Otus\Payment;

use Monolog\Logger;
use Otus\Exceptions\PaymentException;
use Otus\Repository\OrderRepository;

class PaymentService
{

    private array $requestData;
    private bool $error; // чист для теста

    public function __construct(array $requestData, bool $error = false)
    {
        $this->requestData = $requestData;
        $this->error = $error;
    }

    /**
     * @return bool
     * @throws PaymentException
     */
    public function pay(): bool
    {
        //имитация оплаты
        sleep(1);

        if ($this->error){
            throw new PaymentException('payment service error,', PaymentException::PAYMENT_ERROR_CODE);
        }

        $this->requestData['additional_data'] = ['data' => 'data'];

        $orderRepository = new OrderRepository($this->requestData);
        $orderRepository->save();

        return true;
    }
}