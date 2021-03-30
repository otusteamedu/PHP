<?php


namespace Services\Mappers\Orm;


use App\Model\Airline;
use App\Services\Orm\Mappers\AirlineMapper;
use App\Util\Config;
use PDO;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class AirlineMapperTest extends TestCase
{
    protected static ?PDO $pdo;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $container = Config::buildContainerForConsole();
        self::$pdo = $container->get(PDO::class);
    }

    public static function tearDownAfterClass(): void
    {
        self::$pdo = null;
    }


    public function testCRUD()
    {
        $mapper = new AirlineMapper(self::$pdo);

        $raw = [
            'name' => 'Company',
            'abbreviation' => 'CMP',
            'description' => 'Company description'
        ];

        $model = $mapper->insert($raw);

        $this->assertInstanceOf(Airline::class, $model);
        $this->assertEquals('Company', $model->getName());

        $model->setName('New company');

        $this->assertTrue($mapper->update($model));
        $this->assertEquals('New company', $model->getName());

        $model2 = $mapper->findById($model->getId());

        $this->assertSame($model->getName(), $model2->getName());

        $isDelete = $mapper->delete($model);
        $this->assertTrue($isDelete);

        $this->assertNull($mapper->findById($model->getId()));
    }

}
