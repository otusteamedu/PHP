<?php

namespace App\Entity;

class PrivateClient extends Client
{
    private string $passport = '';

    /**
     * @return array
     */
    public function fetchToAssoc(): array
    {
        return [
            'name'     => $this->name,
            'address'  => $this->address,
            'passport' => $this->passport,
        ];
    }

    /**
     * @return string
     */
    public function getPassport(): string
    {
        return $this->passport;
    }

    /**
     * @param string $passport
     * @return PrivateClient
     */
    public function setPassport(string $passport): PrivateClient
    {
        $this->passport = $passport;
        return $this;
    }
}