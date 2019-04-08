<?php

namespace HW7_1;

use PHPUnit\Framework\TestCase;

class ComplexValidationTest extends TestCase
{
    public function testValidateWithoutValidators(): void
    {
        $validNoValidators = new ComplexValidation();
        self::assertTrue($validNoValidators->validate('example@example.com'));
    }

    public function testWithRegExpValidator(): void
    {
        $emValid = new ComplexValidation([new RegexpValidation()]);
        self::assertTrue($emValid->validate('pawigor@gmail.com'));
        self::assertFalse($emValid->validate('pawigor@gmail@com'));
        self::assertTrue($emValid->validate('it_s_valid_email@yeap.com'));
        self::assertFalse($emValid->validate('It\'s not valid email@yeap.com'));
    }

    public function testWithCheckDNSValidator(): void
    {
        $emValid = new ComplexValidation([new CheckDNSValidation()]);
        self::assertTrue($emValid->validate('pawigor@gmail.com'));
        self::assertFalse($emValid->validate('pawigor@gmail@com'));
        self::assertTrue($emValid->validate('inbox@pieware.pro'));
        self::assertFalse($emValid->validate('it_s_not_valid_email@дрын-дын-дын.com'));
    }

    public function testWithBothValidators(): void
    {
        $emValid = new ComplexValidation([new RegexpValidation(), new CheckDNSValidation()]);
        self::assertTrue($emValid->validate('pawigor@gmail.com'));
        self::assertFalse($emValid->validate('pawigor@gmail@com'));
        self::assertTrue($emValid->validate('inbox@pieware.pro'));
        self::assertFalse($emValid->validate('it_s_not_valid_email@дрын-дын-дын.com'));
        self::assertFalse($emValid->validate('It\'s not valid email@gmail.com'));
    }
}
