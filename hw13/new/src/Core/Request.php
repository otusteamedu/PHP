<?php


namespace AYakovlev\Core;


use Exception;

class Request
{
    private string $controller = 'Default';
    private string $method = 'Index';
    /**
     * @var mixed|string|int|null
     */
    private $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $uri = array_diff($uri, ['']);

        // controller/method/id
        if (isset($uri[1])) {
            $this->controller = $uri[1];
        }

        if (isset($uri[2])) {
            $this->method = $uri[2];
        }

        if (isset($uri[3])) {
            $this->id = $uri[3];
        }
//var_dump($uri);
        $this->validateCommand();
    }

    private function validateCommand(): bool
    {
        if (!class_exists("AYakovlev\Controller\\" . ucfirst($this->controller) . "Controller")) {
            throw new Exception("AYakovlev\Controller\\" . ucfirst($this->controller) . "Controller не существует<br>");
        }

        if (!method_exists("AYakovlev\Controller\\" . $this->controller . "Controller", $this->method)) {
            throw new Exception("Метод AYakovlev\Controller\\" . ucfirst($this->controller) . "Controller\\" . $this->method . " не существует<br>");
        }

        if (!is_numeric($this->id) && $this->id != null) {
            throw new Exception("Ошибка параметра Id: '" . $this->id . "' - не число<br>");
        }

        return true;
    }

    public function getController(): string
    {
        return "AYakovlev\Controller\\" . ucfirst($this->controller) . "Controller";
    }

    public function getMethod(): string
    {
        return $this->method;
    }

}