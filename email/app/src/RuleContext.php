<?php

namespace Marchenko;

class RuleContext
{
    private $list;
    private $result;

    public function __construct(array $list)
    {
        $this->list = $list;
    }

    /**
     * @return array $list
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param string $email
     * @param bool $result
     */
    public function setResult(string $email, bool $result)
    {
        $this->result[$email] = $result;
    }

    public function getResult()
    {
        return $this->result;
    }

}
