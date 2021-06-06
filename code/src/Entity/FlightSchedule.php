<?php


namespace App\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use OpenApi\Annotations as OA;

/**
 *
 * @author Alexandr Timofeev <tim31al@gmail.com>
 *
 *
 * @ORM\Entity
 * @ORM\Table(name="flight_schedule")
 * @ORM\HasLifecycleCallbacks
 *
 * @OA\Schema ()
 *
 */
class FlightSchedule implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     *
     * @OA\Property(property="id", type="integer", description="ID рейса", example="123")
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Airline")
     * @ORM\JoinColumn(name="airline_id", referencedColumnName="id")
     *
     * @OA\Property(property="airline", type="string", description="Название авиакомпании", example="Аэроком")
     */
    protected Airline $airline;

    /**
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="departure_id", referencedColumnName="id")
     *
     * @OA\Property(property="departure", type="string", description="Город вылета", example="Москва")
     */
    protected City $departure;

    /**
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="arrival_id", referencedColumnName="id")
     *
     * @OA\Property(property="arrival", type="string", description="Город прилета", example="Амстердам")
     */
    protected City $arrival;

    /**
     * @ORM\Column(name="departure_time", type="datetime")
     *
     * @OA\Property(
     *     property="departure_time",
     *     type="string",
     *     description="Дата и время вылета",
     *     example="2021-01-01T01:01:01+00:00"
     * )
     */
    protected DateTime $departureTime;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \App\Entity\Airline
     */
    public function getAirline(): Airline
    {
        return $this->airline;
    }

    /**
     * @param \App\Entity\Airline $airline
     * @return \App\Entity\FlightSchedule
     */
    public function setAirline(Airline $airline): self
    {
        $this->airline = $airline;
        return $this;
    }

    /**
     * @return \App\Entity\City
     */
    public function getDeparture(): City
    {
        return $this->departure;
    }

    /**
     * @param \App\Entity\City $departure
     * @return \App\Entity\FlightSchedule
     */
    public function setDeparture(City $departure): self
    {
        $this->departure = $departure;
        return $this;
    }

    /**
     * @return \App\Entity\City
     */
    public function getArrival(): City
    {
        return $this->arrival;
    }

    /**
     * @param \App\Entity\City $arrival
     * @return \App\Entity\FlightSchedule
     */
    public function setArrival(City $arrival): self
    {
        $this->arrival = $arrival;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDepartureTime(): DateTime
    {
        return $this->departureTime;
    }

    /**
     * @param \DateTime $departureTime
     * @return \App\Entity\FlightSchedule
     */
    public function setDepartureTime(DateTime $departureTime): self
    {
        $this->departureTime = $departureTime;
        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'airline' => $this->airline->getTitle(),
            'departure' => $this->departure->getName(),
            'arrival' => $this->arrival->getName(),
            'departure_time' => $this->departureTime->format(DATE_ATOM),
        ];
    }
}
