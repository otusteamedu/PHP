<?php
declare(strict_types=1);

namespace App\Tests\Validator\Rule;

use App\Validator\Rule\Brackets;
use App\Validator\ValidatorFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class BracketsTest
 */
class BracketsTest extends TestCase
{
    /**
     * @return void
     */
    public function test(): void
    {
        $validator = ValidatorFactory::create();

        $bracketsRule = new Brackets();

        $this->assertNotEmpty(
            $validator->validate(')(', $bracketsRule)
        );

        $this->assertNotEmpty(
            $validator->validate('())(', $bracketsRule)
        );

        $this->assertNotEmpty(
            $validator->validate('(()()()()))((((()()()))(()()()(((()))))))', $bracketsRule)
        );

        $this->assertEmpty(
            $validator->validate('(())', $bracketsRule)
        );

        $this->assertEmpty(
            $validator->validate('()()', $bracketsRule)
        );
    }
}
