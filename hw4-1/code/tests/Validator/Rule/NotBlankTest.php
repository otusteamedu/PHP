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
    public function test(): void
    {
        $validator = ValidatorFactory::create();

        $notBlankRule = new NotBlank();

        $this->assertNotEmpty(
            $validator->validate('', $notBlankRule)
        );

        $this->assertNotEmpty(
            $validator->validate(false, $notBlankRule)
        );

        $this->assertNotEmpty(
            $validator->validate(null, $notBlankRule)
        );

        $this->assertNotEmpty(
            $validator->validate(0, $notBlankRule)
        );

        $this->assertEmpty(
            $validator->validate('test', $notBlankRule)
        );

        $this->assertEmpty(
            $validator->validate('0', $notBlankRule)
        );
    }
}
