<?php

namespace timga\calculator\tests;

use PHPUnit\Framework\TestCase;
use timga\calculator\ArgumentValidator;
use timga\calculator\Input;

class ArgumentValidatorTest extends TestCase
{

    public function addBadInputDataProvider()
    {
        return [
            [5,1,2,'timga\calculator\Exceptions\IncorrectNumberOfArgumentsException'],
            [4,'a',2,'timga\calculator\Exceptions\IncorrectAValueException'],
            [4,1,'b','timga\calculator\Exceptions\IncorrectBValueException'],
        ];
    }

    /**
     * @dataProvider addBadInputDataProvider
     */
    public function testValidateTrowException($argc, $valueA, $valueB, $expectedException)
    {
        $input = $this->createMock(Input::class);
        $input->method('getArgc')
            ->willReturn($argc);
        $input->method('getValueA')
            ->willReturn($valueA);
        $input->method('getValueB')
            ->willReturn($valueB);

        self::expectException($expectedException);
        new ArgumentValidator($input);
    }

}