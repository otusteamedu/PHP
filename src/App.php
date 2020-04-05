<?php

namespace Bjlag;

use Bjlag\Db\Store;
use Bjlag\Template\Template;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;

class App
{
    /** @var string */
    private static $baseDir;

    /** @var string */
    private static $templateDir;

    /** @var string */
    private static $cacheDir;

    /** @var Template */
    private static $template = null;

    /** @var \Bjlag\Db\Store */
    private static $db = null;

    /**
     * App run.
     */
    public function run(): void
    {
        self::$baseDir = dirname(__DIR__);
        self::$templateDir = self::$baseDir . '/src/Views';
        self::$cacheDir = self::$baseDir . '/cache';

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
            $adapter = 'MongoDb';
            $adapterClass = '\\Bjlag\\Db\\Adapters\\' . $adapter;

            if (!class_exists($adapterClass)) {
                throw new \RuntimeException("Адаптер БД не найден: {$adapterClass}.");
            }

            /** @var \Bjlag\Db\Store $db */
            $db = (new $adapterClass());
            if (!($db instanceof Template)) {
                throw new \RuntimeException("Адаптер БД не найден: {$adapterClass}.");
            }

            self::$db = $db->getConnection($uri, $dbName);
        }

        return self::$db;
    }

    /**
     * @return \Bjlag\Template\Template
     */
    public static function getTemplate(): Template
    {
        if (self::$template === null) {
            $adapter = 'Twig';
            $adapterClass = '\\Bjlag\\Template\\Adapters\\' . $adapter;

            if (!class_exists($adapterClass)) {
                throw new \RuntimeException("Шаблонизатор не найзен: {$adapterClass}.");
            }

            $template = new $adapterClass(self::getCacheDir() . '/twig');
            if (!($template instanceof Template)) {
                throw new \RuntimeException("Шаблонизатор не найзен: {$adapterClass}.");
            }

            self::$template = $template;
        }

        return self::$template;
    }

    /**
     * @return string
     */
    public static function getTemplateDir(): string
    {
        return self::$templateDir;
    }

    /**
     * @return string
     */
    public static function getCacheDir(): string
    {
        return self::$cacheDir;
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
