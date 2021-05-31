<?php


namespace App\Shop;


class IceCream
{
    private bool $wafer = false;
    private bool $syrup = false;
    private bool $chocolate = false;


    public function getStructure(): array
    {
        return [
            'wafer'     => $this->wafer,
            'syrup'     => $this->syrup,
            'chocolate' => $this->chocolate,
        ];
    }

    public function addWafer(bool $wafer)
    {
        $this->wafer = $wafer;
    }

    /**
     * @param bool $syrup
     */
    public function addSyrup(bool $syrup): void
    {
        $this->syrup = $syrup;
    }

    /**
     * @param bool $filling
     */
    public function addChocolate(bool $filling): void
    {
        $this->chocolate = $filling;
    }

}