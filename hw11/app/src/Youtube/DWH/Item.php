<?php


namespace Youtube\DWH;


class Item
{
    protected $id = '';
    protected $data = [];

    public function __construct($id, $data = [])
    {
        $this->id = $id;
        $this->data = $data;
    }


    public function getID()
    {
        return $this->id;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     *
     * @return array
     */
    public function toArray()
    {
        $data = ['_id' => $this->getID()];
        return $data;
    }

    /**
     * @param array $data
     */
    public static function fromArray($data)
    {
        return [];
    }

    public function dumpData()
    {
        echo "<pre>";
        var_dump($this->getID());
        var_dump($this->data);
        echo "</pre>";
    }


}