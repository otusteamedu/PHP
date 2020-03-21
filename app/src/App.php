<?php
namespace Otus\HW11;

use \Otus\HW11\Task2;

class App
{
    protected $response;

    public function run(string $task = 'default')
    {
        $this->response = '';

        if ($task == 'task1') {

            $this->task1();

        } elseif ($task == 'Task2') {

            $this->task2();

        } elseif ($task == 'default') {

            print 'Test <a href="/task1.php">task 1</a> or <a href="/Task2.php">task 2</a> ';

        } else {
            throw new \Exception('Can not run application');
        }
    }


    protected function task1()
    {
        $this->response = 'Homework #11, task 1';
        print $this->response;
    }


    protected function task2()
    {
        $storage = new Task2\RedisStorage();

        if ($_POST['action'] == 'setevent') {

            $arParams = $this->extractConditions( strip_tags($_POST['conditions']) );

            $storage->setEvent(new Task2\Event(
                100,
                $arParams,
                $_POST['event']
            ));

            $this->response = 'Adding new event successful';

        } elseif ($_GET['action'] == 'getevent') {

        } elseif ($_POST['action'] == 'clearevents') {

            $storage->clearEvents();
            $this->response = 'Clearing events successful';

        } else {
            $this->response = 'Send action type...';
        }

        print $this->response;

    }


    /**
     * parse string in format 'param1=val1;param2=val2'
     * @param string $condStr
     * @return array
     */
    protected function extractConditions(string $condStr): array
    {
        $arConditions = [];
        $conditions = explode(';', $condStr);

        foreach ($conditions as $condition) {
            $arTmp = explode('=', $condition);
            $arConditions[$arTmp[0]] = $arTmp[1];
        }

        return $arConditions;
    }
}
