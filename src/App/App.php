<?php

namespace Ozycast\App;

use Exception;
use Ozycast\App\Core\Db;
use Ozycast\App\Core\DbMongo;
use Ozycast\App\Models\Channel;
use Ozycast\App\Models\Video;

Class App
{
    public static $db = null;

    public function __construct()
    {
        self::getDb();
    }

    public function run()
    {
        if (!isset($_SERVER['argv']) && !isset($_SERVER['argv'][1]))
            return "Empty argument";

        try {
            switch ($_SERVER['argv'][1]) {
                case "addChannel":
                    $answer =(new Channel())->addChannel($_SERVER['argv'][2]);
                    break;

                case "channels":
                    $answer = (new Channel())->channels();
                    break;

                case "scanVideo":
                    $answer = (new Video())->scan($_SERVER['argv'][2]);
                    break;

                case "refreshRating":
                    $answer = (new Video())->scanRating();
                    break;

                case "channelRating":
                    $answer = (new Video())->channelWithRating();
                    break;

                case "channelRatingTop":
                    $answer = (new Video())->topVideoRating(10);
                    break;

                case "videos":
                    $answer = (new Video())->videos();
                    break;

                case "lazyLoad":
                    $answer = (new Video())->lazyLoad($_SERVER['argv'][2]);
                    break;
            }
        } catch (Exception $e) {
            $this->showMessage($e->getMessage(), []);
        }

        if (!isset($answer))
            $this->showMessage("Command not fount");

        $this->showMessage($answer['message'], $answer['data']);
    }

    public function getDb(): Db
    {
        self::$db = (new DbMongo())->connect();
        return self::$db;
    }

    public function showMessage($message, $data = [])
    {
        print_r($message."\n\r");
        print_r($data);
    }
}
