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
     * @return mixed
     * @throws PaymentException
     */
    public function pay(): array
    {
        //имитация оплаты
        sleep(1);

        if ($this->error){
            throw new PaymentException('payment service error,',
                PaymentException::PAYMENT_ERROR_CODE);
        }

        $dataFromService = ['data' => 'data'];

        $this->requestData['additional_data'] = $dataFromService;

        return $dataFromService;
    }
}