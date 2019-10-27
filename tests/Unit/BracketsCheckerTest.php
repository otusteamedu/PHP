<?php

namespace Tests\Unit;

use App\BracketsChecker;
use Tests\TestCase;

class BracketsCheckerTest extends TestCase
{
    public function dataProvider()
    {
        return [
            ['(())', true],
            ['(()', false],
            [')(', false],
            ['())', false],
            ['(())', true],
            ['(()()()()))((((()()()))(()()()(((()))))))', false],
            ['(()()()())((((()()()))(()()()(((()))))))', true],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCheck($line, $result)
    {
        $bracketsChecker = new BracketsChecker();

        $this->assertEquals($bracketsChecker->check($line), $result);
    }
}
