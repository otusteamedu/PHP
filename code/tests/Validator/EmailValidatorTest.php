<?php


namespace App\Tests\Validator;


use App\Validator\EmailValidator;
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

        $validator->validate($goodEmail);
        $errors = $validator->getErrors();
        $this->assertEmpty($errors);

        $validator->validate($badEmail);
        $errors = $validator->getErrors();
        $this->assertCount(1, $errors);
        $this->assertContains('Invalid email address', $errors[$badEmail]);

        $validator->clear();

        $validator->validate($badDomain);
        $errors = $validator->getErrors();


        $this->assertCount(1, $errors);
        $this->assertContains('Domain in not valid', $errors[$badDomain]);
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
        $this->assertContains('Domain in not valid', $errors['user@xyz.ru']);
    }


}
