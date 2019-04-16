<?php

namespace timga\calculator\tests;

use PHPUnit\Framework\TestCase;
use timga\calculator\ArgumentValidator;
use timga\calculator\Input;

class ArgumentValidatorTest extends TestCase
{
    public function testValidateTrue()
    {
        $input = $this->createMock(Input::class);
        $input->method('getArgc')
            ->willReturn(4);
        $input->method('getValueA')
            ->willReturn(10);
        $input->method('getValueB')
            ->willReturn(20);

        $validator = new ArgumentValidator();
        $this->assertTrue($validator->validate($input));
    }
}