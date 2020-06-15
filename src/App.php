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
        $this->mapRoutes();

        $this->pdo = new \PDO(
            $this->config['db']['driver'] . ':host=' . $this->config['db']['host'] . ';dbname=' . $this->config['db']['dbname'],
            $this->config['db']['username'],
            $this->config['db']['password']
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

    private function mapRoutes(): void
    {
        // map homepage
        $this->router->map('GET', '/', function () {
            print 'Homework #17';
        });

        $this->router->map('GET', '/init', function () {

            if ($this->initDB()) {
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

    }

    /**
     * @return bool
     */
    private function initDB(): bool
    {
        $script = dirname(__DIR__) . '/sql/init.sql';
        $initSql = file_get_contents($script);

        if ($this->pdo->exec($initSql) === false) {
            return false;
        }

        return true;
    }
}