<?php

namespace Tests\Unit;

use App\EmailValidator;
use Tests\TestCase;

class EmailValidatorTest extends TestCase
{
    public function dataProvider()
    {
        return [
            ['#Ootest@yandex.ru', true],
            ['test@skdhjksdhkjsdhfjkdfsjdfks.ru', false],
            ['test@ynadex.ru', true],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testIsValidEmail($email, $result)
    {
        $emailValidator = new EmailValidator();
        $this->assertEquals($emailValidator->check($email), $result);
    }
}
