<?php
namespace Otus\HW11\Task1;

use \Otus\HW11\Task1;

interface IStatistics
{
    public function getStatistics(Task1\Channel $channel);

    public function getTop();
}