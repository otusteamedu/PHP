<?php

namespace TimGa\DbPatterns\Model\LazyLoad;

class ScheduleCollection extends \ArrayObject
{
    public function offsetSet($index, $newval)
    {
        if (!$newval instanceof Schedule) {
            throw new \InvalidArgumentException("Must be Schedule");
        }

        parent::offsetSet($index, $newval);
    }

}
