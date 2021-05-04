<?php
declare(strict_types=1);

namespace App\Tests\Validator\Rule;

use App\Validator\Rule\Email;
use App\Validator\ValidatorFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailTest
 */
class EmailTest extends TestCase
{
    /**
     * @return void
     */
    public function testRecipientNameMissing(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('@example.com', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testRecipientNameStartsWithSpecialCharacter(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('.test@example.com', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testRecipientNameEndsWithSpecialCharacter(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('test.@example.com', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testRecipientNameContainsTwoConsecutiveSpecialCharacters(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('te..st@example.com', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testAtMissing(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('example.com', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testDomainNameMissing(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('test@.com', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testTopLevelDomainMissing(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('test@example', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testDomainNameContainsInvalidCharacter(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('test@exa_mple.com', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testTopLevelDomainLengthLessThanTwoCharacters(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('test@example.c', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testInvalidDomainName(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('test@example.co', new Email());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testRegularValidAddress(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('test@example.com', new Email());

        $this->assertEmpty($errors);
    }

    /**
     * @return void
     */
    public function testAddressHasSubdomain(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('test@google.co.uk', new Email());

        $this->assertEmpty($errors);
    }

    /**
     * @return void
     */
    public function testAddressConsistsOfNonAsciiCharacters(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('тест@почта.рф', new Email());

        $this->assertEmpty($errors);
    }
}
