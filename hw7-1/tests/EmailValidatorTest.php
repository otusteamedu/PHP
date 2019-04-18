<?php

namespace timga\emailValidator\tests;

use PHPUnit\Framework\TestCase;
use timga\emailValidator\EmailValidator;

class EmailValidatorTest extends TestCase
{
    protected $validator;

    protected function setUp()
    {
        $this->validator = new EmailValidator();
    }

    protected function tearDown()
    {
        $this->validator = null;
    }

    public function emailProvider()
    {
        return [
            ['test@mail.ru', true],
            ['t#st@mail.ru', false],
            ['test@mmail.ru', false],
            ['test@mail@mail.ru', false],
            ['test@@mail.ru', false],
        ];
    }

    /**
     * @param $email string
     * @param $expected bool
     * @dataProvider emailProvider
     */
    public function testValidate($email, $expected)
    {
        $this->validator->setEmail($email);
        $this->assertEquals($expected, $this->validator->validate());
    }
}
