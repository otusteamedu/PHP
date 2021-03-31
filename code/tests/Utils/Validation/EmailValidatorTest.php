<?php


namespace App\Tests\Utils\Validation;


use App\Utils\Validation\EmailValidator;
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{

    public function testValidate()
    {
        $goodEmail = 'user@mail.ru';
        $badEmail = 'user_mail.ru';
        $badDomain = 'user@xyz.ru';

        $validator = new EmailValidator();
        $this->assertInstanceOf(EmailValidator::class, $validator);

        $this->assertTrue($validator->validate($goodEmail));
        $this->assertFalse($validator->validate($badEmail));
        $this->assertFalse($validator->validate($badDomain));

    }

    public function testGetErrors()
    {
        $goodEmail = 'user@mail.ru';
        $badEmail = 'user_mail.ru';
        $badDomain = 'user@xyz.ru';

        $validator = new EmailValidator();

        $status = $validator->validate($goodEmail);
        $this->assertTrue($status);
        $error = $validator->getError();
        $this->assertEquals('', $error);

        $status = $validator->validate($badEmail);
        $this->assertFalse($status);
        $error = $validator->getError();
        $this->assertEquals('Invalid email address', $error);


        $validator->validate($badDomain);
        $error = $validator->getError();
        $this->assertEquals('Domain is not valid', $error);
    }

    public function testValidateAll()
    {
        $emails = [
            'user@mail.ru', 'user_mail.ru', 'user@xyz.ru'
        ];

        $validator = new EmailValidator();

        $result = $validator->validateAll($emails);

        $this->assertFalse($result);
        $this->assertCount(2, $validator->getErrors());

        $errors = $validator->getErrors();

        $this->assertArrayHasKey('user_mail.ru', $errors);
        $this->assertArrayHasKey('user@xyz.ru', $errors);

        $this->assertContains('Invalid email address', $errors['user_mail.ru']);
        $this->assertContains('Domain is not valid', $errors['user@xyz.ru']);
    }
}
