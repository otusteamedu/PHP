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
        $data = json_decode( $request->getJsonData() );
        $storage = new Task1\MongoStorage();

        if ( $request->isAddVideo() ) {

            $video = new Task1\Video([
                'name' => $data->name,
                'url' => $data->url,
                'likes' => $data->likes,
                'dislikes' => $data->dislikes
            ]);

            if ( $storage->addVideo($data->channel_url, $video) ) {
                $this->response = 'Homework #11, task 1: add video successful';
            } else {
                $this->response = 'Homework #11, task 1: add new video failed';
            }

        } elseif ( $request->isAddChannel() ) {

            $channel = new Task1\Channel([
                'name' => $data->name,
                'url' => $data->url,
                'subscribers' => $data->subscribers,
                'videos' => $data->videos
            ]);

            if ( $storage->addChannel($channel) ) {
                $this->response = 'Homework #11, task 1: add channel successful';
            } else {
                $this->response = 'Homework #11, task 1: add new channel failed';
            }

        } elseif ( $request->isShowStatus() ) {

            $storage->showStatus();

        } elseif ( $request->isInitDB() ) {

            $storage->init();
            $this->response = 'Homework #11, task 1: init db successful';

        } elseif ( $request->isDeleteVideo() ) {

            $video = new Task1\Video([
                'name' => '*',
                'url' => $data->url,
                'likes' => 0,
                'dislikes' => 0
            ]);

            if ( $storage->deleteVideo($video) ) {
                $this->response = 'Homework #11, task 1: delete video successful';
            } else {
                $this->response = 'Homework #11, task 1: can not delete video: try to send other url of video';
            }

        } elseif ( $request->isDeleteChannel() ) {

            $channel = new Task1\Channel([
                'name' => '*',
                'url' => $data->url,
                'subscribers' => 0,
            ]);

            if ( $storage->deleteChannel($channel) ) {
                $this->response = 'Homework #11, task 1: delete channel successful';
            } else {
                $this->response = 'Homework #11, task 1: can not delete channel: try to send other url of channel';
            }

        } elseif ( $request->isGetStatistics() ) {

            $result = $storage->getStatistics(new Task1\Channel([
                'name' => '*',
                'url' => $data->url,
                'subscribers' => 0
            ]));

            if ( !is_null($result) ) {
                $this->response = 'Homework #11, task 1: the channel "' . $result->_id . '" has ' . $result->value['likes'] . ' likes and ' . $result->value['dislikes'] . ' dislikes';
            } else {
                $this->response = 'Homework #11, task 1: can not retrieve statistics by ' . $data->url;
            }

        } elseif ( $request->isGetTop() ) {

            $result = $storage->getTop();

            $arChannels = [];
            foreach ($result as $channelStat) {
                $arChannels[$channelStat->value['index']] = [
                    'url' => $channelStat->_id,
                    'likes' => $channelStat->value['likes'],
                    'dislikes' => $channelStat->value['dislikes'],
                    'index' => $channelStat->value['index']
                ];
            }

            /** Sorting by relation value (index) */
            krsort($arChannels);

            print_r($arChannels);

        } else {
            $this->response = 'Homework #11, task 1: send action';
        }

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
