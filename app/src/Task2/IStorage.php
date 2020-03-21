<?php
namespace Otus\HW11\Task2;

interface IStorage
{
    public function setEvent(\Otus\HW11\Task2\Event $event);

    public function queryExec();

    public function clearEvents();
}
