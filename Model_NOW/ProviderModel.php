<?php

namespace Tests\_support\Model;

class ProviderModel extends JsonDataDriver implements ModelInterface
{
    /* наименование */
    public $name;
    /* группа */
    public $group;
    /* регион */
    public $region;
    /* город */
    public $city;
    /* e-mail для отправки запросов по задержкам ответа/поставки */
    public $emailDelayResponseSupply;
    /* срок в часах для расчета задержки ответа от поставщика */
    public $responseHours;
    /* срок в часах для расчета задержки поставки */
    public $supplyHours;

    protected $jsonFileName = 'provider_data.json';

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getEmailDelayResponseSupply()
    {
        return $this->emailDelayResponseSupply;
    }

    /**
     * @param mixed $emailDelayResponseSupply
     */
    public function setEmailDelayResponseSupply($emailDelayResponseSupply)
    {
        $this->emailDelayResponseSupply = $emailDelayResponseSupply;
    }

    /**
     * @return mixed
     */
    public function getResponseHours()
    {
        return $this->responseHours;
    }

    /**
     * @param mixed $responseHours
     */
    public function setResponseHours($responseHours)
    {
        $this->responseHours = $responseHours;
    }

    /**
     * @return mixed
     */
    public function getSupplyHours()
    {
        return $this->supplyHours;
    }

    /**
     * @param mixed $supplyHours
     */
    public function setSupplyHours($supplyHours)
    {
        $this->supplyHours = $supplyHours;
    }


}