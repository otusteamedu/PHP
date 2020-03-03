<?php
namespace Tirei01\Hw12\Storage\Collection\Prorogue;

use Tirei01\Hw12\Mapper;

class Property extends \Tirei01\Hw12\Storage\Collection\Property
{
    private $stm;
    private $valArray;
    private $run = false;

    public function __construct(Mapper $mapper, \PDOStatement $stm, array $valArray)
    {
        parent::__construct(array(), $mapper);
        $this->stm = $stm;
        $this->valArray = $valArray;
    }

    public function notifyAccess()
    {
        if(! $this->run){
            $this->stm->execute($this->valArray);
            $this->raw = $this->stm->fetchAll(\PDO::FETCH_ASSOC);
            $this->total = count($this->raw);
        }
        $this->run = true;
    }
}