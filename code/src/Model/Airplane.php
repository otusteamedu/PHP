<?php


namespace App\Model;


use DateTime;

class Airplane extends OrmAbstractModel
{
    private ?string $name;
    private ?int $number;
    private ?int $seatsCount;
    private ?DateTime $buildDate;
    private ?int $airlineId = null;

    /**
     * @return int|null
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeatsCount(): int
    {
        return $this->seatsCount;
    }

    /**
     * @param int $seatsCount
     */
    public function setSeatsCount(int $seatsCount): self
    {
        $this->seatsCount = $seatsCount;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getBuildDate(): DateTime
    {
        return $this->buildDate;
    }

    /**
     * @param DateTime $buildDate
     */
    public function setBuildDate(DateTime $buildDate): self
    {
        $this->buildDate = $buildDate;
        return $this;
    }


    /**
     * @param int|null $airlineId
     * @return $this
     */
    public function setAirlineId(?int $airlineId): self
    {
        $this->airlineId = $airlineId;
        return $this;
    }

    public function getAirlineId(): ?int
    {
        return $this->airlineId;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'number' => $this->number,
            'seats_count' => $this->seatsCount,
            'build_date' => $this->buildDate->format('Y-m-d'),
            'airline_id' => $this->getAirlineId(),
        ];
    }
}
