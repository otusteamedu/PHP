<?php
namespace Otus\HW11\Task2;

interface IStorage
{
    public function setEvent(\DS\Vector $params, \Otus\HW11\Task2\Event $event);

    public function queryExec(\DS\Vector $params);

    public function clearEvents();
}
