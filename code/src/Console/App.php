<?php


namespace App\Console;


use App\Model\Airline;
use App\Orm\Mapping\AirlineMapper;
use App\Services\Orm\Mappers\AirplaneMapper;
use App\Services\Orm\Repository;
use App\Util\Config;
use Psr\Container\ContainerInterface;


class App extends Console
{
    private ContainerInterface $container;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->container = Config::buildContainerForConsole();
    }

    public function run()
    {
        $m = new Airline();

        echo (new \ReflectionClass($m))->getShortName(), PHP_EOL;


        exit;




        $cancel = false;

        while(!$cancel) {
            echo 'Test redis (r), youtube channels (c),  выход (q): ';
            $answer = $this->readLine();

            switch($answer) {
                case 'r':
                    $redis = new RedisManage($this->container);
                    $redis->run();
                    break;
                case 'c':
                    $youtube = new YoutubeChannelsManage($this->container);
                    $youtube->run();
                    break;
                case 'q':
                default:
                    $cancel = true;
            }
        }
    }

}

