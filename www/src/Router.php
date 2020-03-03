<?php

namespace Tirei01\Hw12;

class Router
{
    private string $url;
    private array $regulations;
    private array $params;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function addRule(string $reg, ?array $params = array())
    {
        if (!array_key_exists('action', $params) || empty($params['action'])) {
            $params['action'] = 'index';
        }
        $this->regulations[] = array(
            'REG' => $reg,
            'PARAMS' => $params,
        );
    }

    private function find(): bool
    {
        foreach ($this->regulations as $regulation) {
            if (preg_match($regulation['REG'], $this->url, $matches)) {
                $this->params = array_merge($regulation['PARAMS'], $matches);
                return true;
                break;
            }
        }
        return false;
    }

    private function getClass($className = 'Controller')
    {
        return 'Tirei01\Hw12\Mvc\Controller\\' . ucwords($className);
    }

    public function run(): string
    {
        if ($this->find()) {
            if ($this->params['model'] && class_exists($this->params['model'])) {
                $modelClass = $this->params['model'];
                $model = new $modelClass($this->params);
                $controllerClass = $this->params['controller'];
                $controllerClass = $this->getClass($controllerClass);
                if ($controllerClass && class_exists($controllerClass)) {
                    $obController = new $controllerClass($model);
                    if (method_exists($obController, $this->params['action'])) {
                        $obController->{$this->params['action']}();
                    }
                    $redirect = $obController->getRedirect();
                    if($redirect){
                        $model->redirect($redirect);
                    }
                    $view = new \Tirei01\Hw12\Mvc\View($obController, $model);
                    return $view->output($this->params['controller'].'.' . $this->params['action']);
                } else {
                    throw new \Exception('controller is bad', 400);
                }
            } else {
                throw new \Exception('model is bad');
            }
        }
        return '';
    }
}

