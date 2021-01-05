<?php

namespace Verify;

use PHPUnit\Framework\TestCase;

class VerifyEmailTest extends TestCase
{

    public function testVerifyEmail()
    {
        $this->assertTrue((new VerifyEmail("v.maltsev90@yandex.ru"))->verifyEmail());
        $this->assertTrue((new VerifyEmail("test.1@mail.ru"))->verifyEmail());
        $this->assertTrue((new VerifyEmail("test.2@gmail.com"))->verifyEmail());
        $this->assertFalse((new VerifyEmail("v.maltsev90@yandex.aaa"))->verifyEmail());
        $this->assertFalse((new VerifyEmail('v.malt$ev90@yandex.ru'))->verifyEmail());
        $this->assertFalse((new VerifyEmail(".v.maltsev90@yandex.ru#"))->verifyEmail());
        $this->assertFalse((new VerifyEmail("v.maltsev90@something.qw"))->verifyEmail());
    }
}