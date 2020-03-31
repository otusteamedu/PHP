<?php
namespace Otus\HW11;

use \Otus\HW11\Task1;
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
        $request = new Task1\Request($_REQUEST);
        $storage = new Task1\MongoStorage();

        if ( $request->isAddVideo() ) {

            $data = json_decode( $request->getJsonData() );
            $video = new Task1\Video([
                'name' => $data->name,
                'url' => $data->url,
                'likes' => $data->likes,
                'dislikes' => $data->dislikes
            ]);

            print_r($video);

        } elseif ( $request->isAddChannel() ) {

            $data = json_decode( $request->getJsonData() );

            $channel = new Task1\Channel([
                'name' => $data->name,
                'url' => $data->url,
                'subscribers' => $data->subscribers,
                'videos' => $data->videos
            ]);

            print_r($channel);

        } elseif ( $request->isShowStatus() ) {
            $storage->showStatus();
        }

        $storage->init();

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
