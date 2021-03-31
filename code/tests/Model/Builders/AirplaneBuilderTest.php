<?php


namespace Model\Builders;


use App\Model\Airline;
use App\Model\Airplane;
use App\Model\Builders\AirplaneBuilder;
use App\Services\Orm\ModelManager;
use App\Utils\Config;
use PHPUnit\Framework\TestCase;

class AirplaneBuilderTest extends TestCase
{
    public function testBuildWithoutAirline()
    {
        $name = 'broiler-747';
        $number = '12345';
        $seatsCount = 100;
        $buildDate = '1973-01-31';

        $raw = [
            'id' => 1,
            'name' => $name,
            'number' => $number,
            'seats_count' => $seatsCount,
            'build_date' => $buildDate,
        ];

        $airplane = (new AirplaneBuilder())->build($raw);

        $this->assertInstanceOf(Airplane::class, $airplane);
        $this->assertEquals($name, $airplane->getName());
        $this->assertEquals($number, $airplane->getNumber());
        $this->assertEquals($seatsCount, $airplane->getSeatsCount());
        $this->assertEquals(new \DateTime($buildDate), $airplane->getBuildDate());
    }

//    public function testBuild()
//    {
//        $airline = new Airline();
//        $airline
//            ->setId(1)
//            ->setName('Company')
//            ->setAbbreviation('CMP');
//
//        $id = 1;
//        $name = 'broiler-747';
//        $number = '12345';
//        $seatsCount = 100;
//        $buildDate = '1973-01-31';
//
//        $raw = [
//            'id' => $id,
//            'name' => $name,
//            'number' => $number,
//            'seats_count' => $seatsCount,
//            'build_date' => $buildDate,
//            'airline_id' => 1,
//        ];
//
//        $airplane = (new AirplaneBuilder())->build($raw);
//
//        $this->assertInstanceOf(Airplane::class, $airplane);
//
//        $this->assertEquals('Company', $airplane->getAirline()->getName());
//        $this->assertEquals('CMP', $airplane->getAirline()->getAbbreviation());
//        $this->assertEquals(1, $airplane->getAirlineId());
//    }
}
