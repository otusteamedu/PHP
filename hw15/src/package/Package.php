<?php


namespace App\package;


class Package
{
    private $id;
    private $type;
    private $countUnits = 1;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param mixed $countUnits
     */
    public function setCountUnits($countUnits)
    {
        $this->countUnits = $countUnits;
        return $this;
    }

}