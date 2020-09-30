<?php


namespace App;

class Router
{
    private ?array $rules = null;

    private array $default = [
        'index' => [
            'controller' => 'base',
            'action' => 'index'
        ],
    ];

    private $di = null;

    public function __construct($di)
    {
        $this->di = $di;
        $this->rules = ($this->di->config['route'] ?: $this->default);
    }

    public function dispatch($dispatch_params = null)
    {
        if (!$dispatch_params) {
            $parsed_url = $this->parseUrl($this->di->request->getUrl());
            $params = $parsed_url['params'];
            if (!isset($this->rules[$parsed_url['controller_url']])) {
                $className = $parsed_url['controller_url'] . 'Controller';
                $action = $parsed_url['action'] . 'Action';
            } else {
                $className = $this->rules[$parsed_url['controller_url']]['controller'] . 'Controller';
                $action = $this->rules[$parsed_url['controller_url']]['action'] . 'Action';
            }
        } else {
            if (empty($dispatch_params['controller']) || empty($dispatch_params['action'])) {
                throw new \Exception('Invalid params');
            }
            $className = $dispatch_params['controller'];
            $action = $dispatch_params['action'];
            $params = !empty($dispatch_params['params']) ? $dispatch_params['params'] : [];
        }

        $controller = '\\App\\Controllers\\' . $className;
        if (class_exists($controller)) {
            $controller_obj = new $controller($this->di);
        } else {
            $this->dispatch([
                'controller' => 'ErrorController',
                'action' => 'errorAction',
            ]);
            return;
        }

        if ( is_callable([$controller_obj, $action]) ) {
            call_user_func_array([$controller_obj, $action], $params);
        } else {
            $this->dispatch([
                'controller' => 'ErrorController',
                'action' => 'errorAction',
            ]);
            return;
        }
    }

    private function parseUrl($url)
    {
        if (empty($url)) return [
            'controller_url' => array_key_first($this->default),
            'action' => $this->default[array_key_first($this->default)]['action'],
        ];

        $url_components = explode('/', $url);
        $controller = $url_components[1];
        $action = !empty($url_components[2]) ? $url_components[2] : 'index';
        $params = !empty($url_components[3]) ? $url_components[3] : [];
        return [
            'controller_url' => $controller,
            'action' => $action,
            'params' => $params,
        ];
    }
}