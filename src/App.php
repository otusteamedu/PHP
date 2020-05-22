<?php
namespace Otus;

use Symfony\Component\Yaml\Yaml;
use Otus\ActiveRecord\AttributeValue;
use Otus\QueueAdapter;

final class App
{
    private $config;
    private $router;
    private $pdo;
    private $queue;

    public function __construct()
    {
        $this->config = Yaml::parseFile(dirname(__DIR__) . '/config.yml');

        $this->router = new \AltoRouter();
        $this->mapRoutes();

        $this->pdo = new \PDO(
            $this->config['db']['driver'] . ':host=' . $this->config['db']['host'] . ';dbname=' . $this->config['db']['dbname'],
            $this->config['db']['username'],
            $this->config['db']['password']
        );

        $this->queue = new QueueAdapter(
            $this->config['queue']['host'],
            $this->config['queue']['username'],
            $this->config['queue']['password'],
            $this->config['queue']['port'],
            $this->pdo
        );
    }

    public function run(): void
    {
        // match current request url
        $match = $this->router->match();

        // call closure or throw 404 status
        if (is_array($match) && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            // no route was matched
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        }
    }

    public function consoleRun()
    {
        // Console consumer
        echo ' [*] Waiting for messages. To exit press CTRL+C' . PHP_EOL . PHP_EOL;
        $this->queue->consuming();
    }

    private function mapRoutes(): void
    {
        // map homepage
        $this->router->map('GET', '/', function () {
            print 'Homework #16';
        });

        $this->router->map('GET', '/init', function () {

            if (AttributeValue::init($this->pdo)) {
                print 'DB initialization successful';
            } else {
                print 'DB initialization error';
            }

        });

        $this->router->map('GET', '/list', function () {
           $list = AttributeValue::getList($this->pdo);
           var_dump($list);
        });

        // Sync method to add new rows
        $this->router->map('POST', '/add/[i:count]', function ($count) {
            $result = AttributeValue::addRandomRows($this->pdo, $count);

            if ($result === true) {
                print "Request to add $count rows executed";
            } else {
                print 'Error is occurred during attempt to add new rows';
            }
        });

        // Async method to add new rows
        $this->router->map('POST', '/acyncadd/[i:count]', function ($count) {
            $this->queue->pushMsg((string) $count);
            print "Your request added to queue.\n";
        });

    }
}