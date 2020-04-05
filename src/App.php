<?php

namespace Bjlag;

use Bjlag\Db\Store;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;

class App
{
    /** @var \Bjlag\Db\Store */
    private static $db = null;

    public function run(): void
    {
        try {
            $request = ServerRequestFactory::fromGlobals();
            $content = $this->processRequest($request);
            $response = new HtmlResponse($content);

            echo $response->getBody();

//            $data = self::getDb()->find('channel', ['name', 'source'], ['source' => 'app']);
//            var_dump($data);
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
            var_dump($e->getTrace());
        }
    }

    /**
     * @return \Bjlag\Db\Store
     */
    public static function getDb(): Store
    {
        if (self::$db === null) {
            $uri = 'mongodb://dev:dev@mongo:27017';
            $dbName = 'youtube';
            $dbAdapter = 'MongoDb';
            $adapterClass = '\\Bjlag\\Db\\Adapters\\' . $dbAdapter;

            /** @var \Bjlag\Db\Store $adapter */
            $adapter = (new $adapterClass());
            self::$db = $adapter->getConnection($uri, $dbName);
        }

        return self::$db;
    }

    /**
     * @param \Laminas\Diactoros\ServerRequest $request
     * @return string
     * @throws \Exception
     */
    private function processRequest(ServerRequest $request): string
    {
        $query = $request->getQueryParams();

        $path = $query['path'] ?? 'site/index';
        $path = trim($path, '/');
        $pathParts = explode('/', $path);

        $controllerName = strtr(ucwords(strtr($pathParts[0], ['-' => ' ', '_' => ' '])), [' ' => '']);
        $controllerAction = $pathParts[1] . 'Action' ?? 'indexAction';
        $controllerArgs = array_slice($query, 1);

        $controllerClass = '\\Bjlag\\Controllers\\' . $controllerName . 'Controller';
        if (!class_exists($controllerClass)) {
            throw new \Exception('404');
        }

        $controller = new $controllerClass();
        if (!method_exists($controller, $controllerAction)) {
            throw new \Exception('404');
        }

        return $controller->$controllerAction($controllerArgs);
    }
}
