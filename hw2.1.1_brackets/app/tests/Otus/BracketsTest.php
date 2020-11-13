<?php

namespace Otus;

use PHPUnit\Framework\TestCase;

class BracketsTest extends TestCase
{
    public function testCheck()
    {
        $this->assertTrue((new Brackets())->check("()()()()"));
        $this->assertTrue((new Brackets())->check("((())())()()"));
        $this->assertFalse((new Brackets())->check(""));
        $this->assertFalse((new Brackets())->check(")()("));
    }
}
