<?php

namespace crazydope\validation\tests;

use crazydope\validation\HostValidator;
use PHPUnit\Framework\TestCase;

class HostValidatorTest
    extends TestCase
{
    /**
     * @var HostValidator
     */
    protected $hostValidator;

    protected function setUp()
    {
        $this->hostValidator = new HostValidator();
    }

    protected function tearDown()
    {
        $this->hostValidator = null;
    }

    public function hostProvider(): array
    {
        return [
            [false,[]],
            [false,'halskjdhflaskjdhfalsdkfj'],
            [true,'москва.рф'],
            [true,'yandex.ru'],
        ];
    }

    /**
     * @param $expected
     * @param $host
     * @dataProvider hostProvider
     */
    public function testValidateHostname($expected, $host): void
    {
        $this->assertSame($expected, $this->hostValidator->isValid($host));
    }
}