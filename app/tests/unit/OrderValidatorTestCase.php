<?php


namespace OtusTest\unit;


use Otus\Validator\OrderValidator;
use PHPUnit\Framework\TestCase;

class OrderValidatorTestCase extends TestCase
{
    /**
     * @dataProvider orderValidateDataProvider
     */
    public function testOrderValidate(array $requestData)
    {
        $validator = new OrderValidator($requestData);
        $result = $validator->validate();

        static::assertTrue($result);
    }

    public function orderValidateDataProvider(): array
    {
        return [
            'test_1' => [
                [
                    'card_number' => '1234567890123456',
                    'card_holder' => 'RS',
                    'card_expiration' => '2022-12-12',
                    'cvv' => '123',
                    'order_number' => 'ASD123',
                    'sum' => '1500,87'
                ]
            ],
            'test_2' => [
                [
                    'card_number' => '123456789',
                    'card_holder' => 'RS',
                    'card_expiration' => '2022-12-12',
                    'cvv' => '123',
                    'order_number' => 'ASD123',
                    'sum' => '1500,87'
                ]
            ],
        ];
    }
}