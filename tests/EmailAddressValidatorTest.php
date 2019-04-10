<?php

namespace crazydope\validation\tests;

use crazydope\validation\EmailAddressValidator;
use PHPUnit\Framework\TestCase;

class EmailAddressValidatorTest
    extends TestCase
{
    /**
     * @var EmailAddressValidator
     */
    protected $emailValidator;

    protected function setUp()
    {
        $this->emailValidator = new EmailAddressValidator();
    }

    protected function tearDown()
    {
        $this->emailValidator = null;
    }

    public function emailProvider(): array
    {
        return [
            [true, 'crazydope@gmail.com'],
            [true, '"asdf"@gmail.com'],
            [false, []],
            [false, 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz@gmail.com'],
            [false, 'ошибка@gmail.com'],
            [false, 'test@test.ru'],
            [false, 'crazydope@localhost'],
            [false, 'gmail.com'],
        ];
    }

    /**
     * @param $expected
     * @param $email
     * @dataProvider emailProvider
     */
    public function testValidateEmailAddress( $expected, $email ): void
    {
        $this->assertSame($expected, $this->emailValidator->isValid($email));
    }
}