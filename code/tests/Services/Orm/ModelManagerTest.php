<?php


namespace Services\Orm;


use App\Model\Airline;
use App\Model\Airplane;
use App\Services\Orm\ModelManager;
use App\Services\Orm\Repository;
use App\Util\Config;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ModelManagerTest extends TestCase
{
    protected static ?ContainerInterface $container;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$container = Config::buildContainerForConsole();
    }

    public static function tearDownAfterClass(): void
    {
        self::$container = null;
    }

    public function testController()
    {
        $mm = new ModelManager(self::$container);
        $this->assertInstanceOf(ModelManager::class, $mm);
    }

    public function testGetRepository()
    {
        $mm = new ModelManager(self::$container);
        $repo1 = $mm->getRepository(Airline::class);
        $this->assertInstanceOf(Repository::class, $repo1);

        $repo2 = $mm->getRepository(Airline::class);
        $this->assertSame($repo1, $repo2);

        $repo3 = $mm->getRepository(Airplane::class);
        $this->assertNotSame($repo3, $repo2);

        $repo4 = $mm->getRepository(Airplane::class);
        $this->assertSame($repo3, $repo4);
    }

    public function testSaveDelete()
    {
        $mm = new ModelManager(self::$container);

        $airline = new Airline();
        $airline->setName('Company');
        $airline->setAbbreviation('CMP');
        $airline->setDescription('Company description');

        $mm->save($airline);
        $this->assertTrue($airline->getId() !== null);

        $this->assertTrue($mm->delete($airline));
    }

    public function testUpdate()
    {
        $mm = new ModelManager(self::$container);

        $airline = new Airline();
        $airline->setName('Company');
        $airline->setAbbreviation('CMP');
        $airline->setDescription('Company description');

        $mm->save($airline);

        $id = $airline->getId();
        $airline->setName('Test company');
        $airline->setAbbreviation('CMP2');
        $airline->setDescription('Test company');

        $mm->save($airline);

        $this->assertEquals($id, $airline->getId());
        $this->assertEquals('Test company', $airline->getName());
        $this->assertEquals('CMP2', $airline->getAbbreviation());
        $this->assertEquals('Test company', $airline->getDescription());

        $this->assertTrue($mm->delete($airline));
    }

    public function testIdentityMap()
    {
        $mm = new ModelManager(self::$container);

        $airline = new Airline();
        $airline->setName('Company');
        $airline->setAbbreviation('CMP');
        $airline->setDescription('Company description');

        $mm->save($airline);

        $repo = $mm->getRepository(Airline::class);
        $airline2 = $repo->findOne($airline->getId());

        $this->assertSame($airline, $airline2);

        $mm->delete($airline);
    }

    public function testRepositoryFindAll()
    {
        $mm = new ModelManager(self::$container);

        $airline = new Airline();
        $airline->setName('Company');
        $airline->setAbbreviation('CMP');
        $airline->setDescription('Company description');

        $mm->save($airline);

        $repo = $mm->getRepository(Airline::class);
        $models = $repo->findAll();

        $this->assertCount(2, $models);

        $mm->delete($airline);
    }

}
