<?php


namespace App\Tests\Utils\Validation;


use App\Utils\Validation\BracesValidator;

class BracesValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testValidateEmptyString()
    {
        $validator = new BracesValidator();
        $this->assertInstanceOf(BracesValidator::class, $validator);

        $value = '';

        $result = $validator->validate($value);
        $this->assertFalse($result);

        $errors = $validator->getErrors();

        $this->assertContains('Length == 0', $errors);

    }

    public function testValidateBadString()
    {
        $validator = new BracesValidator();

        $value = '2222';

        $result = $validator->validate($value);
        $this->assertFalse($result);

        $this->assertContains('Wrong format', $validator->getErrors());

    }

    public function testValidateOpenedBraces()
    {
        $validator = new BracesValidator();

        $value = '(()()()()))((((()()()))(()()()(((()))))))';

        $result = $validator->validate($value);
        $this->assertFalse($result);

        $errors = $validator->getErrors();
        $this->assertContains('Not closed', $validator->getErrors());

        $validator->clear();

        $value = ')(';

        $result = $validator->validate($value);
        $this->assertFalse($result);

        $errors = $validator->getErrors();

        $this->assertContains('Not closed', $validator->getErrors());
    }

    public function testValidateGoodBraces()
    {
        $validator = new BracesValidator();

        $value = '()';

        $result = $validator->validate($value);
        $this->assertTrue($result);

        $this->assertEmpty($validator->getErrors());


        $value = '((((((()))))))()';

        $result = $validator->validate($value);
        $this->assertTrue($result);

        $this->assertEmpty($validator->getErrors());
    }
}

