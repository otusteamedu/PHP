<?php

namespace Tests\Unit;

use App\EmailValidators\SyntaxValidator;
use Tests\TestCase;

class SyntaxValidatorTest extends TestCase
{
    public function emailProvider()
    {
        return [
            ['test@skdhjksdh.ru', true],
            ['!#Ootest@yandex.ru', true],
            ['.....2FDJfd@ya.ru', false],
        ];
    }

    /**
     * @dataProvider emailProvider
     */
    public function testIsValidEmail($email, $result)
    {
        $syntaxValidator = new SyntaxValidator();
        $this->assertEquals($syntaxValidator->isValidEmail($email), $result);
    }
}
