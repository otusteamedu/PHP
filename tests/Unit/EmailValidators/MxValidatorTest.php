<?php

namespace Tests\Unit;

use App\EmailValidators\MxValidator;
use Tests\TestCase;

class MxValidatorTest extends TestCase
{
    public function emailProvider()
    {
        return [
            ['test@yandex.ru', true],
            ['test@skdhjksdhkjsdhfjkdfsjdfks.ru', false],
        ];
    }

    /**
     * @dataProvider emailProvider
     */
    public function testIsValidEmail($email, $result)
    {
        $mxValidator = new MxValidator();
        $this->assertEquals($mxValidator->isValidEmail($email), $result);
    }
}
