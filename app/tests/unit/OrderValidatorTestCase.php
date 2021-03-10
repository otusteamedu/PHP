<?php


namespace OtusTest\unit;


use Monolog\Logger;
use Otus\Exceptions\ValidationException;
use Otus\Validator\OrderValidator;
use PHPUnit\Framework\TestCase;

class OrderValidatorTestCase extends TestCase
{
    /**
     * @dataProvider orderValidDataProvider
     */
    public function testOrderValidateWithValidData(array $requestData)
    {
        $_ENV['LOG_PATH'] = '../logs/app.log';
        $validator = new OrderValidator($requestData);
        $result = $validator->validate();

        static::assertTrue($result);
    }

    public function orderValidDataProvider(): array
    {
        return [
            'test_1' => [
                [
                    'card_number' => '1234567890123456',
                    'card_holder' => 'Rustem Yessaliyev',
                    'card_expiration' => '2021-12-12',
                    'cvv' => '123',
                    'order_number' => 'ASD123',
                    'sum' => '101'
                ]
            ],
            'test_2' => [
                [
                    'card_number' => '1234567890123456',
                    'card_holder' => 'Rustem Yessaliyev',
                    'card_expiration' => '2022-12-12',
                    'cvv' => '000',
                    'order_number' => '1111',
                    'sum' => 1500
                ]
            ],
        ];
    }

    /**
     * @dataProvider orderInvalidDataProvider
     */
    public function testOrderValidateWithInvalidData(array $requestData)
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionCode(Logger::ERROR);

        $_ENV['LOG_PATH'] = '../logs/app.log';
        $validator = new OrderValidator($requestData);
        $validator->validate();
    }

    public function orderInvalidDataProvider(): array
    {
        return [
            'test_1' => [
                [
                    'card_number' => '123456789012',
                    'card_holder' => 'RS',
                    'card_expiration' => '2022-12-12',
                    'cvv' => '123',
                    'order_number' => 'ASD123',
                    'sum' => '1500,87'
                ]
            ],
            'test_2' => [
                [
                    'card_number' => '1234567890123456',
                    'card_holder' => '',
                    'card_expiration' => '2022-12-12',
                    'cvv' => '000',
                    'order_number' => '1111',
                    'sum' => '150087'
                ]
            ],
            'test_3' => [
                [
                    'card_number' => '1234567890123456',
                    'card_holder' => 'R Yessaliyev F',
                    'card_expiration' => '2026-12-12',
                    'cvv' => '000',
                    'order_number' => '1111',
                    'sum' => '150087'
                ]
            ],
            'test_4' => [
                [
                    'card_number' => '1234567890123456',
                    'card_holder' => 'R R',
                    'card_expiration' => '2022-12-12',
                    'cvv' => '000',
                    'order_number' => '',
                    'sum' => '15000'
                ]
            ],
            'test_5' => [
                [
                    'card_number' => '1234567890123456',
                    'card_holder' => 'RS ASD',
                    'card_expiration' => '2022-12-12',
                    'cvv' => '000',
                    'order_number' => 'asd123',
                    'sum' => -15000
                ]
            ]
        ];
    }
}