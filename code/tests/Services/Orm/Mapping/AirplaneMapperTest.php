<?php


namespace Services\Mappers\Orm;


use App\Model\Airplane;
use App\Services\Orm\Mapping\AirplaneMapper;
use App\Services\Orm\ModelManager;
use App\Utils\Config;
use DateTime;
use PDO;
use PHPUnit\Framework\TestCase;

class AirplaneMapperTest extends TestCase
{
    protected static ?ModelManager $mm;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $container = Config::buildContainer();
        self::$mm = $container->get(ModelManager::class);
    }

    public static function tearDownAfterClass(): void
    {
        self::$mm = null;
    }

    public function testCRUD()
    {
        $mapper =  new AirplaneMapper(self::$mm);

        $name = 'broiler-747';
        $number = '12345';
        $seatsCount = 100;
        $buildDate = '1973-01-31';
        $airlineId = 1;
        $raw = [
            'name' => $name,
            'number' => $number,
            'seats_count' => $seatsCount,
            'build_date' => $buildDate,
            'airline_id' => $airlineId ?? null,
        ];

        $model = $mapper->insert($raw);

        $this->assertInstanceOf(Airplane::class, $model);

        $this->assertEquals($name, $model->getName());
        $this->assertEquals($number, $model->getNumber());
        $this->assertEquals($seatsCount, $model->getSeatsCount());
        $this->assertEquals(new DateTime($buildDate), $model->getBuildDate());

        $model->setName('new name');
        $model->setBuildDate(new DateTime('2021-01-01'));

        $this->assertTrue($mapper->update($model));

        $model2 = $mapper->findById($model->getId());
        $this->assertEquals('new name', $model2->getName());
        $this->assertEquals(new DateTime('2021-01-01'), $model2->getBuildDate());

        $this->assertTrue($mapper->delete($model));
    }

}
