<?php
declare(strict_types=1);

use lexerom\Email\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $email = new Email('example');
    }

    public function testParts(): void
    {
        $localPart = 'example';
        $domain = 'example.com';

        $email = new Email($localPart . '@' . $domain);

        $this->assertEquals($localPart, $email->getLocalPart());
        $this->assertEquals($domain, $email->getDomain());
    }
}
