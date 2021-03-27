<?php


namespace App\Console;


use DI\Container;
use DI\ContainerBuilder;


class App extends Console
{
    const CONFIG_DIR = __DIR__ . '/../../config';

    private Container $container;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(self::CONFIG_DIR . '/services.php');
        $this->container = $builder->build();
    }

    public function run()
    {
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

