<?php
declare(strict_types=1);

namespace App\Tests\Validator\Rule;

use App\Validator\Rule\NotBlank;
use App\Validator\ValidatorFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class NotBlankTest
 */
class NotBlankTest extends TestCase
{

    /**
     * @return void
     */
    public function testEmptyString(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('', new NotBlank());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testFalse(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate(false, new NotBlank());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testNull(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate(null, new NotBlank());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testZeroInteger(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate(0, new NotBlank());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testEmptyArray(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate([], new NotBlank());

        $this->assertNotEmpty($errors);
    }

    /**
     * @return void
     */
    public function testRegularString(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('test', new NotBlank());

        $this->assertEmpty($errors);
    }

    /**
     * @return void
     */
    public function testZeroString(): void
    {
        $validator = ValidatorFactory::create();

        $errors = $validator->validate('0', new NotBlank());

        $this->assertEmpty($errors);
    }
}
