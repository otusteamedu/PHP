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

        } elseif ($task == 'task2') {

            $this->task2();

        } elseif ($task == 'default') {

            print 'Test <a href="/task1.php">task 1</a> or <a href="/Task2.php">task 2</a> ';

        } else {
            throw new \Exception('Can not run application');
        }
    }


    protected function task1()
    {
        $client = new \MongoDB\Client("mongodb://mongo:27017");
        $collection = $client->demo->beers;

        $result = $collection->insertOne( [ 'name' => 'Hinterland', 'brewery' => 'BrewDog' ] );

        echo "Идентификатор вставленного документа '{$result->getInsertedId()}'\n";

        $result = $collection->find( [ 'name' => 'Hinterland', 'brewery' => 'BrewDog' ] );

        foreach ($result as $entry) {
            echo $entry['_id'], ': ', $entry['name'], "\n";
        }

        $this->response = 'Homework #11, task 1';
        print $this->response;
    }


    protected function task2()
    {
        $storage = new Task2\RedisStorage();

        if ($_POST['action'] == 'setevent') {

            $request = new Task2\Request($_POST);

            $storage->setEvent(
                $request->getConditions(),
                $request->getEvent()
            );

            $this->response = 'Adding new event successful';

        } elseif ($_GET['action'] == 'getevent') {

            $request = new Task2\Request($_GET);
            $event = $storage->queryExec( $request->getParams() );

            if ( is_null($event) ) {
                $this->response = 'Appropriate event not found';
            } else {
                print_r($event);
                $this->response = 'Event extracting successful';
            }

        } elseif ($_POST['action'] == 'clearevents') {

            $storage->clearEvents();
            $this->response = 'Clearing events successful';

        } else {
            $this->response = 'Send action type...';
        }

        print $this->response;
    }

}
