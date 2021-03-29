<?php


namespace App\Controllers;


use App\Core\Request;
use App\Core\View;

class BaseController
{
    protected string $content;
    protected string $title = 'Test project';

    protected function viewResponse() : void
    {
        echo $this->renderView('layout', [
            'content' => $this->content,
            'title' => $this->title,
            'currentUrl' => Request::getInstance()->getRequestUri(),
        ]);
    }

    protected function redirect($route, $code = 301)
    {
        header('Location: ' . $_ENV['APP_URL'] . $route, true, $code);
        exit();
    }

    protected function renderView(string $viewPath, array $arguments = [])
    {
        return (new View($viewPath, $arguments))->render();
    }
}