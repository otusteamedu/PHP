<?php

namespace Ozycast\App;

Class App
{
    public static $db = null;

    public function __construct()
    {
        self::getDb();
    }

    public function run()
    {
        if (!isset($_SERVER['argv'][1]))
            return "Empty argument";

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
                $answer = (new Video())->scanRating($_SERVER['argv'][2]);
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
        }

        if (!isset($answer))
            $this->showMessage("Command not fount");

        $this->showMessage($answer['message'], $answer['data']);
    }

    public function getDb()
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
