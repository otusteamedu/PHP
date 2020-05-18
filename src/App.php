<?php
namespace Otus;

use Symfony\Component\Yaml\Yaml;
use Otus\ActiveRecord\AttributeValue;

final class App
{
    private $config;
    private $router;
    private $pdo;

    public function __construct()
    {
        $this->config = Yaml::parseFile(dirname(__DIR__) . '/config.yml');
        $this->router = new \AltoRouter();
        $this->pdo = new \PDO(
            $this->config['db']['driver'] . ':host=' . $this->config['db']['host'] . ';dbname=' . $this->config['db']['dbname'],
            $this->config['db']['username'],
            $this->config['db']['password']
        );
        $this->mapRoutes();
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

    private function mapRoutes(): void
    {
        // map homepage
        $this->router->map('GET', '/', function() {
            print 'Homework #16';
        });

        $this->router->map('GET', '/init', function() {

            if (AttributeValue::init($this->pdo)) {
                print 'DB initialization successful';
            } else {
                print 'DB initialization error';
            }

        });

        $this->router->map('GET', '/list', function() {
           $list = AttributeValue::getList($this->pdo);
           var_dump($list);
        });

        $this->router->map('POST', '/add/[i:count]', function($count) {
            print "Try to add $count rows\n";

            $result = AttributeValue::addRandomRows($this->pdo, $count);

            if ($result === true) {
                print 'Success';
            } else {
                print 'Error';
            }
        });

    }
}