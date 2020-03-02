<?php

use App\App;
use App\EmailValidator\DNSCheckValidation;
use App\EmailValidator\EmailValidator;
use App\EmailValidator\RegexValidation;
use Codeception\Test\Unit;

class EmailValidatorTest extends Unit
{
    protected UnitTester $tester;

    public function testEmailValidator(): void
    {
        $validator = new EmailValidator();

        $emails_valid = [
            'john.doe-max+pain@example.com',
            'test@gmail.com',
        ];
        foreach ($emails_valid as $mail) {
            $result = $validator->isValid($mail, [DNSCheckValidation::class, RegexValidation::class]);
            $this->assertTrue($result);
        }

        $emails_invalid = [
            'mail@serverfault.com',
            'hello@',
            '@test',
            'email@gmail',
            'problem@test@gmail.com',
            'вася@мыло.рф',
        ];
        foreach ($emails_invalid as $mail) {
            $result = $validator->isValid($mail, [DNSCheckValidation::class, RegexValidation::class]);
            $this->assertFalse($result);
            $error = $validator->getError();
            $this->assertNotEmpty($error);
        }

        $exception = false;
        try {
            $validator->isValid('', [App::class]);
        }
        catch (Throwable $e) {
            $exception = true;
        }
        $this->assertTrue($exception);
    }
}
