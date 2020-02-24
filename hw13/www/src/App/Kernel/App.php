<?php declare(strict_types=1);

namespace App\Kernel;

use App\Config\Config;
use App\Repository\Repository;

class App
{
    /**
     * @var \PDO
     */
    private static $pdo;
    /**
     * @var Request
     */
    private static $request;
    /**
     * @var Config
     */
    private static $config;

    /**
     * App constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        self::$config = new Config();
        self::$pdo = self::$config->createDbClient();
        self::$request = new Request();
    }

    public function run()
    {
        $repository = new Repository();
        $mapper = $repository->load(self::$request->getEntity());

        // todo Router - Strategy

        // example
        $item = $mapper->findById((int) self::$request->get("id"));
        $view = new Response();
        $view->renderView(($item->getFirstName()));
        $view->send();
    }

    /**
     * @param string $component
     * @return object
     * @throws \Exception
     */
    public function getInstance(string $component): object
    {
        if (!self::$$component) {
            throw new \Exception("Component {$component} not found");
        }

        return self::$$component;
    }
}