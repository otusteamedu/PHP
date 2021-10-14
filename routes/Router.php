<?php

namespace Routes;


use App\Exceptions\ErrorCodes;
use App\Exceptions\Router\InvalidRouteException;
use App\Exceptions\Router\InvalidRouteMethodException;
use App\Http\Response\IResponse;
use App\Http\Response\ResponseSelector;
use App\Http\Controllers\LoginController;
use Exception;

/**
 * Маршрутизатор
 */
class Router
{
    const CONTROLLERS_BASE_PATH = 'App/Http/Controllers';
    const DEFAULT_PHP_START_FILE = 'index.php';

    /**
     * Вызывает метод по маршруту (точка запуска)
     *
     */
    public static function run(): void
    {
        $response = Router::getResponse();
        [$route, $method, $parameter] = Router::getRoute();
        try {
            if (class_exists($route)) {
                $app = new $route($response);
                if (method_exists($app, $method)) {
                    empty($parameter)
                        ? $app->{$method}()
                        : $app->{$method}($parameter);
                } else {
                    throw new InvalidRouteMethodException("Method '$method' does not found in the Controller", ErrorCodes::getCode(InvalidRouteException::class));
                }
            } else {
                throw new InvalidRouteException("Route does not found", ErrorCodes::getCode(InvalidRouteException::class));
            }
        } catch (Exception $ex) {
            $response->send($ex->getCode(), $ex->getMessage());
        }
    }

    private static function getRoute(): array
    {
        $steps = 3;
        $controller = $method = $parameter ='';
        $controllersBasePath = $_ENV['CONTROLLERS_BASE_PATH'] ?? self::CONTROLLERS_BASE_PATH;
        $startPhpFile = $_ENV['DEFAULT_PHP_START_FILE'] ?? self::DEFAULT_PHP_START_FILE;
        $serviceRoot = $_SERVER['REQUEST_URI'] ?? '/';
        $serviceRoot = (empty(substr($serviceRoot, 1)) || substr($serviceRoot, 1) === $startPhpFile || mb_substr($serviceRoot, 1,1) === '?')
            ? '/' . $_ENV['DEFAULT_CONTROLLER_NAME']
            : $serviceRoot;
        $serviceRoot[1] = strtoupper($serviceRoot[1]);
        while (false !== $lastPos = strrpos($serviceRoot, '/')) {
            $class = preg_replace('/\//', "\\", $controllersBasePath . $serviceRoot) . 'Controller';
            if (class_exists($class)) {
                $controller = $class;
                break;
            };
            $parameter = $method;
            $method = substr($serviceRoot, $lastPos+1);
            $serviceRoot = substr($serviceRoot, 0, $lastPos);
            if (--$steps === 0) break;
        }
        return [
            $controller ,
            (!empty($method) && $method[0] !== '?')
                ? explode("?" , $method)[0]
                : $_ENV['DEFAULT_CONTROLLER_METHOD'],
            (!empty($parameter) && $parameter[0] !== '?')
                ? explode("?" , $parameter)[0]
                : '',
        ];
    }

    static private function getResponse(): IResponse
    {
        return (new ResponseSelector())->getResponse();
    }

}