<?php

namespace App\Entity;

class CorporateClient extends Client
{
    private string $inn = '';

    /**
     * @return array
     */
    public function fetchToAssoc(): array
    {
        return [
            'name'    => $this->name,
            'address' => $this->address,
            'inn'     => $this->inn,
        ];
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @param string $inn
     * @return CorporateClient
     */
    public function setInn(string $inn): CorporateClient
    {
        $this->inn = $inn;
        return $this;
    }
}