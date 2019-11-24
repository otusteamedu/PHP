<?php

namespace Core;

use Throwable;

class App
{
    /** @var AppResponse $response */
    protected $response;

    /** @var AppConfig $appConf */
    protected $appConf;

    /** @var AppNode $appNode */
    private $appNode;

    private static $routesMap = [];
    private static $viewsPath = "";

    /**
     * App constructor.
     * @param AppConfig $appConf
     * @param string|null $reqStr
     */
    public final function __construct(?AppConfig $appConf = null, ?string $reqStr = null)
    {
        $this->response = new AppResponse();
        $this->appNode = new AppNode();
        if ($appConf instanceof AppConfig) {
            $this->appConf = $appConf;
            $this->buildRequest($reqStr ?? $_SERVER["REQUEST_URI"] ?? "");
        }
    }

    /**
     * @param string|null $routesPath
     */
    public static function setRoutes(?string $routesPath)
    {
        foreach (json_decode(file_get_contents($routesPath)) as $node) {
            self::$routesMap[$node->request] = $node;
        }
    }

    /**
     * @param string $viewsPath
     */
    public static function setViewsPath(string $viewsPath): void
    {
        self::$viewsPath = $viewsPath;
    }

    public function run()
    {
        if ($this->appNode->isExists()) {
            try {
                $this->runHandler();
                if ($this->appNode->isPage()) {
                    $this->showPage();
                }
                $this->response->flush(200);
            } catch (AppException $e) {
                $this->response->content = $e->getMessage();
                $this->response->flush($e->getCode() ?: 200);
                exit;
            } catch (Throwable $e) {
                $this->response->flush(500);
                exit;
            }
        } else {
            $this->response->flush(404);
            exit;
        }
    }

    /**
     * @param $reqStr
     */
    private function buildRequest($reqStr)
    {
        $req = parse_url($reqStr);
        $mapNodeRow = self::$routesMap[$req["path"] ?? "404"] ?? null;
        if ($mapNodeRow) {
            $this->appNode = new AppNode($mapNodeRow);
        }
    }

    /**
     * @throws AppException
     */
    private function runHandler()
    {
        if (!empty($this->appNode->getControllerName())) {
            $controller = AppController::getInstance($this->appNode->getControllerName());
            $controller->setResponse($this->response);
            $controller->setAppConfig($this->appConf);
            if (method_exists($controller, $this->appNode->getMethodName())) {
                $controller->{$this->appNode->getMethodName()}();
            }
        }
    }

    /**
     * @throws AppException
     */
    private function showPage()
    {
        if (file_exists(self::$viewsPath . $this->appNode->getPage())) {
            require_once self::$viewsPath . $this->appNode->getPage();
            echo "<div>", $_SERVER["SERVER_ADDR"], "</div>";
            exit;
        } else {
            throw new AppException("", 500);
        }
    }
}