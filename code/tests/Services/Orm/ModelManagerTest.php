<?php


namespace Services\Orm;


use App\Model\Airline;
use App\Model\Airplane;
use App\Services\Orm\ModelManager;
use App\Services\Orm\Repository;
use App\Utils\Config;
use DateTime;
use PHPUnit\Framework\TestCase;

class ModelManagerTest extends TestCase
{
    protected static ?ModelManager $mm;

    public static function setUpBeforeClass(): void
    {
        $container = Config::buildContainerForConsole();
        self::$mm = new ModelManager($container);
    }

    public static function tearDownAfterClass(): void
    {
        self::$mm = null;
    }

    public function testGetRepository()
    {
        $repo1 = self::$mm->getRepository(Airline::class);
        $this->assertInstanceOf(Repository::class, $repo1);

        $repo2 = self::$mm->getRepository(Airline::class);
        $this->assertSame($repo1, $repo2);

        $repo3 = self::$mm->getRepository(Airplane::class);
        $this->assertNotSame($repo3, $repo2);

        $repo4 = self::$mm->getRepository(Airplane::class);
        $this->assertSame($repo3, $repo4);
    }

    public function testSaveDeleteAirline()
    {
        $airline = new Airline(self::$mm);
        $airline->setName('Company');
        $airline->setAbbreviation('CMP');
        $airline->setDescription('Company description');

        self::$mm->save($airline);
        $this->assertTrue($airline->getId() !== null);

        $this->assertTrue(self::$mm->delete($airline));
    }

    public function testSaveDeleteAirplane()
    {
        $airplane = new Airplane();

        $airplane->setName('air');
        $airplane->setNumber(12345);
        $airplane->setSeatsCount(100);
        $airplane->setBuildDate(new \DateTime('1970-01-01'));

        self::$mm->save($airplane);

        $this->assertNotNull($airplane->getId());
        $this->assertTrue(self::$mm->delete($airplane));
    }

    public function testLazyLoadAirplane()
    {
        $airplane = new Airplane();

        $airplane->setName('air');
        $airplane->setNumber(12345);
        $airplane->setSeatsCount(100);
        $airplane->setBuildDate(new \DateTime('1970-01-01'));
        $airplane->setAirlineId(1);

        self::$mm->save($airplane);

        $airline = $airplane->airline;
        print_r($airline);


        $this->assertNotNull($airplane->getId());
        $this->assertTrue(self::$mm->delete($airplane));
    }

    public function testUpdateAirline()
    {
        $airline = new Airline(self::$mm);
        $airline->setName('Company');
        $airline->setAbbreviation('CMP');
        $airline->setDescription('Company description');

        self::$mm->save($airline);

        $id = $airline->getId();
        $airline->setName('Test company');
        $airline->setAbbreviation('CMP2');
        $airline->setDescription('Test company');

        self::$mm->save($airline);

        $this->assertEquals($id, $airline->getId());
        $this->assertEquals('Test company', $airline->getName());
        $this->assertEquals('CMP2', $airline->getAbbreviation());
        $this->assertEquals('Test company', $airline->getDescription());

        $this->assertTrue(self::$mm->delete($airline));
    }

    public function testUpdateAirplane()
    {
        $airplane = new Airplane();

        $airplane->setName('air');
        $airplane->setNumber(12345);
        $airplane->setSeatsCount(100);
        $airplane->setBuildDate(new \DateTime('1970-01-01'));

        self::$mm->save($airplane);

        $id = $airplane->getId();
        $airplane->setName('new name');
        $airplane->setNumber(54321);
        $airplane->setSeatsCount(200);
        $airplane->setBuildDate(new \DateTime('1990-01-01'));

        self::$mm->save($airplane);

        $this->assertEquals($id, $airplane->getId());
        $this->assertEquals('new name', $airplane->getName());
        $this->assertEquals(54321, $airplane->getNumber());
        $this->assertEquals(200, $airplane->getSeatsCount());
        $this->assertEquals(new DateTime('1990-01-01'), $airplane->getBuildDate());

        $this->assertTrue(self::$mm->delete($airplane));
    }

    public function testIdentityMap()
    {
        $airline = new Airline(self::$mm);
        $airline->setName('Company');
        $airline->setAbbreviation('CMP');
        $airline->setDescription('Company description');

        self::$mm->save($airline);

        $repo = self::$mm->getRepository(Airline::class);
        $airline2 = $repo->findOne($airline->getId());

        $this->assertSame($airline, $airline2);

        self::$mm->delete($airline);
    }
}
