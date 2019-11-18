<?php

use App\Event;

class App
{
    public static function init()
    {
        $first = new Event();
        echo "hello" . "<br>";
        $first->deleteAllEvents();
        $first->setName('andrew');
        $first->setPriority(5000);
        $first->setConditions(['param1' => 1, 'param2' => 2]);
        echo $first->save() . "<br>";
        $first->setName('Len');
        $first->setPriority(6000);
        $first->setConditions(['param1' => 1]);
        echo $first->save() . "<br>";
        $first->setName('Den');
        $first->setPriority(9000);
        $first->setConditions(['param1' => 2, 'param2' => 2]);
        echo $first->save() . "<br>";
        echo $first->getPriorityEvent(['params' => ['param1' => 1, 'param2' => 2, 'param3' => 1554]]) . "<br>";
    }
}
