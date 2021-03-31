<?php


namespace Services\Orm;


use App\Model\Airline;
use App\Model\Airplane;
use App\Services\Orm\Exceptions\OrmModelNotFoundException;
use App\Services\Orm\Mapping\AirlineMapper;
use App\Services\Orm\Mapping\AirplaneMapper;
use App\Services\Orm\ModelManager;
use App\Services\Orm\Repository;
use App\Utils\Config;
use PDO;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    protected static ?PDO $pdo;
    protected static ?ModelManager $mm;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $container = Config::buildContainerForConsole();
        self::$pdo = $container->get(PDO::class);
        self::$mm = $container->get(ModelManager::class);
    }

    public static function tearDownAfterClass(): void
    {
        self::$pdo = null;
        self::$mm = null;
    }

    public function testNotFoundRepository()
    {
        $this->expectException(OrmModelNotFoundException::class);
        new Repository('Model', self::$pdo, self::$mm);
    }

    public function testAirlineRepository()
    {
        $repo = new Repository(Airline::class, self::$pdo, self::$mm);

        $this->assertInstanceOf(Repository::class, $repo);
        $this->assertInstanceOf(AirlineMapper::class, $repo->getMapper());

        $airline = $repo->findOne(1);
        $this->assertInstanceOf(Airline::class, $airline);
        $this->assertEquals('Aeroflot', $airline->getName());

        $models = $repo->findAll();
        $this->assertCount(2, $models);

        $models = $repo->find(['name' => 'Aeroflot']);
        $this->assertCount(1, $models);

        $models = $repo->find(['abbreviation' => 'GZP']);
        $this->assertCount(1, $models);

        $models = $repo->find(['abbreviation' => 'GZP', 'name' => 'No name']);
        $this->assertCount(0, $models);
    }

    public function testAirplanesRepository()
    {
        $repo = new Repository(Airplane::class, self::$pdo, self::$mm);

        $this->assertInstanceOf(Repository::class, $repo);
        $this->assertInstanceOf(AirplaneMapper::class, $repo->getMapper());

        $airplane = $repo->findOne(1);
        $this->assertInstanceOf(Airplane::class, $airplane);
        $this->assertEquals('Broiler 747', $airplane->getName());

        $models = $repo->findAll();
        $this->assertCount(2, $models);

        $models = $repo->find(['name' => 'Broiler 747']);
        $this->assertCount(1, $models);

        $models = $repo->find(['seats_count' => 150]);
        $this->assertCount(1, $models);

        $models = $repo->find(['number' => 555, 'name' => 'No name']);
        $this->assertCount(0, $models);
    }

}
