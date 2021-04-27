<?php

namespace v2\Helpers\DataTransferObjects;

class GeoRectangle
{
    private string $minLongitude;
    private string $minLatitude;
    private string $maxLongitude;
    private string $maxLatitude;

    public function __construct(
        string $minLongitude,
        string $minLatitude,
        string $maxLongitude,
        string $maxLatitude
    ){
        $this->minLongitude = $minLongitude;
        $this->minLatitude = $minLatitude;
        $this->maxLongitude = $maxLongitude;
        $this->maxLatitude = $maxLatitude;
    }

    /**
     * @return string
     */
    public function getMinLongitude(): string
    {
        return $this->minLongitude;
    }

    /**
     * @param string $minLongitude
     */
    public function setMinLongitude(string $minLongitude): void
    {
        $this->minLongitude = $minLongitude;
    }

    /**
     * @return string
     */
    public function getMinLatitude(): string
    {
        return $this->minLatitude;
    }

    /**
     * @param string $minLatitude
     */
    public function setMinLatitude(string $minLatitude): void
    {
        $this->minLatitude = $minLatitude;
    }

    /**
     * @return string
     */
    public function getMaxLongitude(): string
    {
        return $this->maxLongitude;
    }

    /**
     * @param string $maxLongitude
     */
    public function setMaxLongitude(string $maxLongitude): void
    {
        $this->maxLongitude = $maxLongitude;
    }

    /**
     * @return string
     */
    public function getMaxLatitude(): string
    {
        return $this->maxLatitude;
    }

    /**
     * @param string $maxLatitude
     */
    public function setMaxLatitude(string $maxLatitude): void
    {
        $this->maxLatitude = $maxLatitude;
    }

}