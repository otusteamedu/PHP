<?php

namespace Otus;

use PHPUnit\Framework\TestCase;

class StringValidatorTest extends TestCase
{
    public function testValidate()
    {
        $this->assertTrue((new StringValidator('()()()'))->validate());
        $this->assertTrue((new StringValidator('((()()))()'))->validate());
        $this->assertTrue((new StringValidator('((((((()()())))())))'))->validate());
        $this->assertTrue((new StringValidator('((((()()))))'))->validate());
        $this->assertFalse((new StringValidator(')('))->validate());
        $this->assertFalse((new StringValidator('((()()'))->validate());
        $this->assertFalse((new StringValidator('()()()()()())'))->validate());
        $this->assertFalse((new StringValidator('())(((()))'))->validate());
    }
}