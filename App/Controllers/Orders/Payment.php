<?php


namespace Controllers\Orders;

use Controllers\Contracts\PaymentInterface;
use Controllers\Orders\PaymentData;
use Exception\CardValidatorExceptions\CurlException;
use Logger\Logger;
use Source\CurlRequest;
use Source\HttpResponses;

class Payment implements PaymentInterface
{
    private $data;
    private $request;

    public function __construct(array $data, CurlRequest $request)
    {
        $this->data = $data;
        $this->request = $request;
    }

    /**
     * Метод отправки данных в платежный шлюз
     * @return string
     */
    public function pay(): string
    {

        try {

            // отправляем запрос на сервер оплаты
            $this->request->setData($this->data);
            $this->request->setUrl(PaymentData::PAYMENT_URL);

            $result = $this->request->send();

        } catch (CurlException $e) {
            Logger::logToFile(PaymentData::LOG_FILE_NAME, $e->getMessage());

            http_response_code(403);

            echo HttpResponses::response(403, $e->getMessage());
        }

        return $result;
    }
}