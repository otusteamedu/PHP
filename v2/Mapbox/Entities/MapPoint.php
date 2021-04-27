<?php

namespace v2\Mapbox\Entities;

class MapPoint
{
    private int $id;
    private string $country;
    private string $region;
    private string $city;
    private string $address;
    private string $longitude;
    private string $latitude;
    private bool $isRecent = false;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCoordinatesToString(): string
    {
        return $this->longitude && $this->latitude ? "{$this->longitude},{$this->latitude}" : '';
    }

    /**
     * @return string
     */
    public function getFullAddress(): string
    {
        return "{$this->country} {$this->city} {$this->region} {$this->address}";
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return bool
     */
    public function isRecent(): bool
    {
        return $this->isRecent;
    }

    /**
     * @param bool $isRecent
     */
    public function setIsRecent(bool $isRecent): void
    {
        $this->isRecent = $isRecent;
    }


}