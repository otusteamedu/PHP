<?php


namespace Entity;


use App\Entity\HotDog;
use PHPUnit\Framework\TestCase;

class HotDogTest extends TestCase
{
    public function testHotDog()
    {
        $hotDog = new HotDog();
        $this->assertInstanceOf(HotDog::class, $hotDog);
        $this->assertEquals('Хот дог', $hotDog->getType());
    }

    public function testClone()
    {
        $hotDog = new HotDog();
        $clone = clone $hotDog;
        $this->assertNotSame($hotDog, $clone);
    }
}
