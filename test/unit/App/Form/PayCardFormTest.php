<?php

namespace Test\unit\App\Form;

use App\Form\PayCardForm;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class PayCardFormTest extends TestCase
{
    /** @var \Laminas\Diactoros\ServerRequest */
    private $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new ServerRequest();
    }

    public function testValidForm()
    {
        $request = $this->request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => '676',
            'order_number' => 'qwer1234asdf1234',
            'sum' => '124,11',
        ]);

        $form = new PayCardForm($request);

        self::assertTrue($form->isValidate(), 'Form should be valid');
        self::assertFalse($form->hasErrors(), 'Should return false');
        self::assertEmpty($form->getErrors(), 'Array with errors should be empty');
    }

    public function testCorruptForm()
    {
        $request = $this->request->withParsedBody([
            'card_expiration' => '01/23',
            'cvv' => '676',
            'order_number' => 'qwer1234asdf1234',
            'sum' => '124,11',
        ]);

        $form = new PayCardForm($request);

        self::assertFalse($form->isValidate(), 'Form should be invalid');
    }

    /**
     * @dataProvider cardNumberDataProvider
     * @param string $cardNumber
     */
    public function testInvalidCardNumber($cardNumber)
    {
        $request = $this->request->withParsedBody([
            'card_number' => $cardNumber,
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => '676',
            'order_number' => 'qwer1234asdf1234',
            'sum' => '124,11',
        ]);

        $form = new PayCardForm($request);

        self::assertFalse($form->isValidate(), 'Form should be invalid');
        self::assertNotEmpty($errors = $form->getErrors(), 'Array with errors should be empty');
        self::assertArrayHasKey(PayCardForm::CARD_NUMBER, $errors, 'Array error should consist card number error');
    }

    public function cardNumberDataProvider(): array
    {
        return [
            'consist not digit' => ['123456789012345f'],
            'greater than 16' => ['12345678901234567'],
            'less than 16' => ['123456789012345'],
            'empty' => [''],
        ];
    }

    /**
     * @dataProvider cardHolderDataProvider
     * @param string $cardHolder
     */
    public function testInvalidCardHolder($cardHolder)
    {
        $request = $this->request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => $cardHolder,
            'card_expiration' => '01/23',
            'cvv' => '676',
            'order_number' => 'qwer1234asdf1234',
            'sum' => '124,11',
        ]);

        $form = new PayCardForm($request);

        self::assertFalse($form->isValidate(), 'Form should be invalid');
        self::assertNotEmpty($errors = $form->getErrors(), 'Array with errors should be empty');
        self::assertArrayHasKey(PayCardForm::CARD_HOLDER, $errors, 'Array error should consist card number error');
    }

    public function cardHolderDataProvider(): array
    {
        return [
            'only last name' => ['SMITH'],
            'two spaces' => ['SMITH JONE J'],
            'digits' => ['1234 55775'],
            'empty' => [''],
        ];
    }

    /**
     * @dataProvider cardExpirationDataProvider
     * @param string $cardExpiration
     */
    public function testInvalidCardExpiration($cardExpiration)
    {
        $request = $this->request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => $cardExpiration,
            'cvv' => '676',
            'order_number' => 'qwer1234asdf1234',
            'sum' => '124,11',
        ]);

        $form = new PayCardForm($request);

        self::assertFalse($form->isValidate(), 'Form should be invalid');
        self::assertNotEmpty($errors = $form->getErrors(), 'Array with errors should be empty');
        self::assertArrayHasKey(PayCardForm::CARD_EXPIRATION, $errors, 'Array error should consist card number error');
    }

    public function cardExpirationDataProvider(): array
    {
        return [
            'only month' => ['10/'],
            'only year' => ['/20'],
            'wrong month 1' => ['0/20'],
            'wrong month 2' => ['13/20'],
            'wrong separate' => ['12|20'],
            'wrong year' => ['12/2020'],
            'not digits' => ['mm/yy'],
            'empty' => [''],
        ];
    }

    /**
     * @dataProvider cvvDataProvider
     * @param string $cvv
     */
    public function testInvalidCvv($cvv)
    {
        $request = $this->request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => $cvv,
            'order_number' => 'qwer1234asdf1234',
            'sum' => '124,11',
        ]);

        $form = new PayCardForm($request);

        self::assertFalse($form->isValidate(), 'Form should be invalid');
        self::assertNotEmpty($errors = $form->getErrors(), 'Array with errors should be empty');
        self::assertArrayHasKey(PayCardForm::CVV, $errors, 'Array error should consist card number error');
    }

    public function cvvDataProvider(): array
    {
        return [
            'greater than 3' => ['1111'],
            'less than 3' => ['22'],
            'not digit' => ['22f'],
            'empty' => [''],
        ];
    }

    /**
     * @dataProvider orderNumberDataProvider
     * @param string $orderNumber
     */
    public function testInvalidOrderNumber($orderNumber)
    {
        $request = $this->request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => '123',
            'order_number' => $orderNumber,
            'sum' => '124,11',
        ]);

        $form = new PayCardForm($request);

        self::assertFalse($form->isValidate(), 'Form should be invalid');
        self::assertNotEmpty($errors = $form->getErrors(), 'Array with errors should be empty');
        self::assertArrayHasKey(PayCardForm::ORDER_NUMBER, $errors, 'Array error should consist card number error');
    }

    public function orderNumberDataProvider(): array
    {
        return [
            'greater than 16' => ['12345678901234567'],
            'less than 16' => ['123456789012345'],
            'empty' => [''],
        ];
    }

    /**
     * @dataProvider sumDataProvider
     * @param string $sum
     */
    public function testInvalidSum($sum)
    {
        $request = $this->request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => '123',
            'order_number' => '1234567890123456',
            'sum' => $sum,
        ]);

        $form = new PayCardForm($request);

        self::assertFalse($form->isValidate(), 'Form should be invalid');
        self::assertNotEmpty($errors = $form->getErrors(), 'Array with errors should be empty');
        self::assertArrayHasKey(PayCardForm::SUM, $errors, 'Array error should consist card number error');
    }

    public function sumDataProvider(): array
    {
        return [
            'wrong separate' => ['125.56'],
            'wrong number 1' => ['123,ff'],
            'wrong number 2' => ['123,'],
            'wrong number 3' => [',45'],
            'negative' => ['-45,45'],
            'empty' => [''],
        ];
    }

    /**
     * @dataProvider validSumDataProvider
     * @param string $sum
     */
    public function testValidSum($sum)
    {
        $request = $this->request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => '123',
            'order_number' => '1234567890123456',
            'sum' => $sum,
        ]);

        $form = new PayCardForm($request);

        self::assertTrue($form->isValidate(), 'Form should be valid');
    }

    public function validSumDataProvider(): array
    {
        return [
            'num 1' => ['125,56'],
            'num 2' => ['125,5'],
            'num 3' => ['125'],
            'num 4' => ['0,45'],
        ];
    }
}
