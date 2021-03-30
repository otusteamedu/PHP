<?php


namespace Services\Orm;


use App\Model\Airline;
use App\Services\Orm\IdentityMap;
use PHPUnit\Framework\TestCase;

class IdentityMapTest extends TestCase
{
    public function testGetInstance()
    {
        $inst1 = IdentityMap::getInstance();
        $inst2 = IdentityMap::getInstance();

        $this->assertSame($inst1, $inst2);
    }

    public function testGetSet()
    {
        $im = IdentityMap::getInstance();

        $this->assertNull($im->get(Airline::class, 1));

        $model = new Airline();
        $model->setId(1);
        $model->setName('Aeroflot');

        $im->set($model);
        $model2 = $im->get(Airline::class, 1);
        $this->assertSame($model, $model2);
    }

}
