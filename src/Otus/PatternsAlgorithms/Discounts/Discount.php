<?php


namespace App\Otus\PatternsAlgorithms\Discounts;


abstract class Discount
{
    /**
     * Name of the discount (overwritten by child classes).
     *
     * @var string
     */
    protected $name;

    /**
     * Discount percentage.
     *
     * @var float
     */
    protected $percentage;

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
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPercentage(): float
    {
        return $this->percentage;
    }

    /**
     * @param float $percentage
     */
    public function setPercentage(float $percentage): void
    {
        $this->percentage = $percentage;
    }

}