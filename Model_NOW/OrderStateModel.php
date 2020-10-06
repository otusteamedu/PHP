<?php

namespace Tests\_support\Model;

/**
 * Class OrderStateModel
 * @package Tests\_support\Model
 */
class OrderStateModel extends JsonDataDriver implements ModelInterface
{
    /* название состояния */
    public $name;
    /* по умолчанию */
    public $default;
    /* финальное */
    public $archive;
    /* условие финальности */
    public $archiveCondition;
    /* статистика поставщика */
    public $providerStat;
    /* наследуемое */
    public $inherited;
    /* невидимое */
    public $invisible;

    protected $jsonFileName = 'order_state_data.json';

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
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @return mixed
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * @param mixed $archive
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
    }

    /**
     * @return mixed
     */
    public function getArchiveCondition()
    {
        return $this->archiveCondition;
    }

    /**
     * @param mixed $archiveCondition
     */
    public function setArchiveCondition($archiveCondition)
    {
        $this->archiveCondition = $archiveCondition;
    }

    /**
     * @return mixed
     */
    public function getProviderStat()
    {
        return $this->providerStat;
    }

    /**
     * @param mixed $providerStat
     */
    public function setProviderStat($providerStat)
    {
        $this->providerStat = $providerStat;
    }

    /**
     * @return mixed
     */
    public function getInherited()
    {
        return $this->inherited;
    }

    /**
     * @param mixed $inherited
     */
    public function setInherited($inherited)
    {
        $this->inherited = $inherited;
    }

    /**
     * @return mixed
     */
    public function getInvisible()
    {
        return $this->invisible;
    }

    /**
     * @param mixed $invisible
     */
    public function setInvisible($invisible)
    {
        $this->invisible = $invisible;
    }


}