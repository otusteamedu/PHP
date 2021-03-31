<?php


namespace Services\Orm;


use App\Model\Airline;
use App\Services\Orm\IdentityMap;
use App\Services\Orm\ModelManager;
use App\Utils\Config;
use PHPUnit\Framework\TestCase;

class IdentityMapTest extends TestCase
{
    protected static ?ModelManager $mm;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $container = Config::buildContainerForConsole();
        self::$mm = $container->get(ModelManager::class);
    }

    public static function tearDownAfterClass(): void
    {
        self::$mm = null;
    }

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

        $model = new Airline(self::$mm);
        $model->setId(1);
        $model->setName('Aeroflot');

        $im->set($model);
        $model2 = $im->get(Airline::class, 1);
        $this->assertSame($model, $model2);
    }

    public function testDelete()
    {
        $im = IdentityMap::getInstance();

        $model = new Airline(self::$mm);
        $model->setId(22);
        $model->setName('AirCompany');

        $im->set($model);
        $m = $im->get(Airline::class, 22);
        $this->assertInstanceOf(Airline::class, $m);

        $im->delete($model);
        $this->assertNull($im->get(Airline::class, 22));
    }

}
