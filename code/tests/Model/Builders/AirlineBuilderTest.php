<?php


namespace Model\Builders;


use App\Model\Airline;
use App\Model\Builders\AirlineBuilder;
use App\Services\Orm\ModelManager;
use App\Utils\Config;
use PHPUnit\Framework\TestCase;

class AirlineBuilderTest extends TestCase
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
    public function testBuild()
    {
        $name = 'Aeroflot';
        $abbreviation = 'AER';
        $description = 'Good company';
        $id = 1;

        $raw = [
            'name' => $name,
            'abbreviation' => $abbreviation,
            'description' => $description,
            'id' => $id,
        ];

        $airline = (new AirlineBuilder(self::$mm))->build($raw);

        $this->assertInstanceOf(Airline::class, $airline);
        $this->assertEquals($id, $airline->getId());
        $this->assertEquals($name, $airline->getName());
        $this->assertEquals($abbreviation, $airline->getAbbreviation());
        $this->assertEquals($description, $airline->getDescription());
    }
}
