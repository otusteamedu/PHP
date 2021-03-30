<?php


namespace Model\Builders;


use App\Model\Airline;
use App\Model\Builders\AirlineBuilder;
use PHPUnit\Framework\TestCase;

class AirlineBuilderTest extends TestCase
{
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

        $airline = (new AirlineBuilder())->build($raw);

        $this->assertInstanceOf(Airline::class, $airline);
        $this->assertEquals($id, $airline->getId());
        $this->assertEquals($name, $airline->getName());
        $this->assertEquals($abbreviation, $airline->getAbbreviation());
        $this->assertEquals($description, $airline->getDescription());
    }
}
