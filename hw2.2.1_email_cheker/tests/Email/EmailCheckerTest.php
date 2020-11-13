<?php

namespace Email;

use PHPUnit\Framework\TestCase;

class EmailCheckerTest extends TestCase
{

    public function testCheck()
    {
        $this->assertTrue((new EmailChecker())->check("help@otus.ru"));
        $this->assertTrue((new EmailChecker())->check("vasya@mail.ru"));
        $this->assertTrue((new EmailChecker())->check("vasya@gmail.com"));
        $this->assertFalse((new EmailChecker())->check("vasya@gmail.qqq"));
        $this->assertFalse((new EmailChecker())->check("vasya@gmail.com."));
        $this->assertFalse((new EmailChecker())->check("vasya@gmail"));
    }
}
