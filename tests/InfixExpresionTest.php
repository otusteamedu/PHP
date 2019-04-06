<?php

namespace HW5_1;

use PHPUnit\Framework\TestCase;

class InfixExpresionTest extends TestCase
{
    /**
     * @return array
     */
    public function variants(): array
    {
        return [
            ['infix' => '1 + ( 3 - 4)', 'postfix' => '1 3 4 - +'],
            ['infix' => '13 + 16 * 17', 'postfix' => '13 16 17 * +'],
            ['infix' => '11 % 12 *13', 'postfix' => '11 12 % 13 *'],
            ['infix' => '1 + 2 * ( 3 -4 / ( 5 + 6 ) )', 'postfix' => '1 2 3 4 5 6 + / - * +'],
        ];
    }

    /**
     * @dataProvider variants
     * @param string $infix
     * @param string $postfix
     */
    public function testToPostfix(string $infix, string $postfix): void
    {
        $expr = new InfixExpresion($infix);
        self::assertEquals($postfix, $expr->toPostfix());
    }
}
