<?php

namespace App\Tests;

use App\MessageGenerator;
use PHPUnit\Framework\TestCase;

class MessageGeneratorTest extends TestCase
{
    public function testCanCreateMessage()
    {
        $messageGenerator = new MessageGenerator();
        $this->assertInstanceOf(MessageGenerator::class, $messageGenerator);
    }

    public function testGetMessage()
    {
        $messageGenerator = new MessageGenerator();

        for ($i = 0; $i < 5; $i++)
        {
            $message = $messageGenerator->getMessage();
            $this->assertNotEmpty($message);
        }
    }

}
